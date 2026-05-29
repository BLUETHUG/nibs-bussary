<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Database;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

class ReportController {
    public function index(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer', 'accountant');

        $db = Database::getConnection();

        $summary = [
            'total_applications' => $db->query("SELECT COUNT(*) FROM applications")->fetchColumn(),
            'total_approved'     => $db->query("SELECT COUNT(*) FROM applications WHERE status='approved'")->fetchColumn(),
            'total_disbursed'    => $db->query("SELECT COALESCE(SUM(amount),0) FROM disbursements")->fetchColumn(),
            'by_status'          => $db->query("SELECT status, COUNT(*) as count FROM applications GROUP BY status")->fetchAll(),
            'by_course'          => $db->query("SELECT s.course, COUNT(*) as count FROM applications a JOIN students s ON a.student_id=s.id GROUP BY s.course")->fetchAll(),
            'by_gender'          => $db->query("SELECT s.gender, COUNT(*) as count FROM applications a JOIN students s ON a.student_id=s.id GROUP BY s.gender")->fetchAll(),
            'monthly_disbursed'  => $db->query("SELECT strftime('%Y-%m', disbursed_at) as month, SUM(amount) as total FROM disbursements GROUP BY month ORDER BY month DESC LIMIT 12")->fetchAll(),
        ];

        require __DIR__ . '/../Views/admin/reports.php';
    }

    public function exportPdf(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer', 'accountant');

        $db = Database::getConnection();
        $applications = $db->query("
            SELECT a.*, u.full_name, u.index_number, s.course, s.year_of_study
            FROM applications a JOIN students s ON a.student_id=s.id JOIN users u ON s.user_id=u.id
            ORDER BY a.created_at DESC
        ")->fetchAll();

        $html = $this->buildReportHtml($applications);

        if (class_exists(\Dompdf\Dompdf::class)) {
            $dompdf = new \Dompdf\Dompdf(['enable_remote' => true]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('nibs_bursary_report_' . date('Ymd') . '.pdf', ['Attachment' => true]);
        } else {
            echo $html;
        }
    }

    public function exportExcel(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer', 'accountant');

        $db = Database::getConnection();
        $rows = $db->query("
            SELECT u.full_name, u.index_number, s.course, s.year_of_study, s.gender,
                   a.academic_year, a.status, a.amount_requested, a.amount_approved, a.created_at
            FROM applications a JOIN students s ON a.student_id=s.id JOIN users u ON s.user_id=u.id
        ")->fetchAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=nibs_bursary_report_' . date('Ymd') . '.csv');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Name','Index No','Course','Year','Gender','Acad Year','Status','Requested(KES)','Approved(KES)','Date']);
        foreach ($rows as $r) {
            fputcsv($out, [$r['full_name'],$r['index_number'],$r['course'],$r['year_of_study'],$r['gender'],$r['academic_year'],$r['status'],$r['amount_requested'],$r['amount_approved'],$r['created_at']]);
        }
        fclose($out);
    }

    private function buildReportHtml(array $applications): string {
        $appConfig = require __DIR__ . '/../../config/app.php';
        $logo = $appConfig['logo_url'];
        $date = date('d M Y');
        $rows = '';
        foreach ($applications as $a) {
            $status = ucfirst($a['status']);
            $rows .= "<tr>
                <td>{$a['full_name']}</td>
                <td>{$a['index_number']}</td>
                <td>{$a['course']}</td>
                <td>{$a['academic_year']}</td>
                <td><span class=\"badge badge-{$a['status']}\">{$status}</span></td>
                <td>KES " . number_format((float)$a['amount_requested'],2) . "</td>
                <td>KES " . number_format((float)$a['amount_approved'],2) . "</td>
            </tr>";
        }

        return <<<HTML
        <!DOCTYPE html><html><head><meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; font-size: 11px; color: #1a1a2e; }
            .header { text-align: center; border-bottom: 3px solid #0a1f5c; padding-bottom: 12px; margin-bottom: 20px; }
            .header img { height: 60px; }
            h1 { color: #0a1f5c; font-size: 18px; margin: 6px 0; }
            .date { color: #666; font-size: 10px; }
            table { width: 100%; border-collapse: collapse; margin-top: 15px; }
            th { background: #0a1f5c; color: #FFD700; padding: 8px 6px; text-align: left; font-size: 10px; }
            td { padding: 6px; border-bottom: 1px solid #e0e0e0; }
            tr:nth-child(even) { background: #f8f9ff; }
            .badge { padding: 2px 8px; border-radius: 10px; font-size: 9px; font-weight: bold; }
            .badge-approved { background: #d4edda; color: #155724; }
            .badge-pending { background: #fff3cd; color: #856404; }
            .badge-rejected { background: #f8d7da; color: #721c24; }
            .badge-disbursed { background: #cce5ff; color: #004085; }
            .footer { margin-top: 30px; border-top: 1px solid #ccc; padding-top: 10px; text-align: center; font-size: 9px; color: #999; }
        </style>
        </head><body>
        <div class="header">
            <img src="{$logo}" alt="NIBS Logo">
            <h1>NIBS Technical College — Bursary Applications Report</h1>
            <div class="date">Generated: {$date}</div>
        </div>
        <table>
            <thead><tr><th>Student Name</th><th>Index No.</th><th>Course</th><th>Year</th><th>Status</th><th>Amount Requested</th><th>Amount Approved</th></tr></thead>
            <tbody>{$rows}</tbody>
        </table>
        <div class="footer">NIBS Technical College — Bursary Management System &copy; {$date}</div>
        </body></html>
        HTML;
    }
}
