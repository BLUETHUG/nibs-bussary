import React, { useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
import { gsap } from 'gsap';
import { Users, FileText, CheckCircle, XCircle, DollarSign, TrendingUp, Clock, AlertTriangle } from 'lucide-react';

const recentApps = [
  { id: 'APP-2026-010', name: 'Alice Wanjiku', course: 'ICT', amount: 'KSh 30,000', status: 'pending', date: '2026-05-25' },
  { id: 'APP-2026-009', name: 'Brian Odhiambo', course: 'Business Admin', amount: 'KSh 45,000', status: 'approved', date: '2026-05-23' },
  { id: 'APP-2026-008', name: 'Carol Muthoni', course: 'Accounting', amount: 'KSh 20,000', status: 'rejected', date: '2026-05-20' },
  { id: 'APP-2026-007', name: 'David Kipchoge', course: 'Journalism', amount: 'KSh 35,000', status: 'pending', date: '2026-05-18' },
  { id: 'APP-2026-006', name: 'Eve Achieng', course: 'Education', amount: 'KSh 40,000', status: 'approved', date: '2026-05-16' },
];

export default function AdminDashboard() {
  const containerRef = useRef(null);

  useEffect(() => {
    gsap.fromTo('.admin-card', { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.5, stagger: 0.1, ease: 'power3.out' });
  }, []);

  const stats = [
    { icon: <FileText size={22} />, label: 'Total Applications', value: '247', color: '#60a5fa', change: '+12 this week' },
    { icon: <CheckCircle size={22} />, label: 'Approved', value: '183', color: '#34d399', change: '74% approval rate' },
    { icon: <Clock size={22} />, label: 'Pending Review', value: '41', color: '#fbbf24', change: '7 urgent' },
    { icon: <XCircle size={22} />, label: 'Rejected', value: '23', color: '#f87171', change: '9% rejection rate' },
    { icon: <Users size={22} />, label: 'Registered Students', value: '1,284', color: '#a78bfa', change: '+34 this month' },
    { icon: <DollarSign size={22} />, label: 'Total Disbursed', value: 'KSh 8.3M', color: '#34d399', change: 'This semester' },
  ];

  return (
    <div className="container page-container" ref={containerRef}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: '2rem', flexWrap: 'wrap', gap: '1rem' }}>
        <div>
          <h1 style={{ fontSize: '1.75rem', fontWeight: '700', margin: 0 }}>Admin Dashboard</h1>
          <p style={{ color: '#94a3b8', marginTop: '0.25rem' }}>Bursary Management System — Overview</p>
        </div>
        <div style={{ display: 'flex', gap: '0.75rem' }}>
          <Link to="/admin/applications" className="btn btn-primary" style={{ textDecoration: 'none', fontSize: '0.875rem', padding: '0.6rem 1.2rem' }}>Review Applications</Link>
          <Link to="/admin/students" className="btn btn-outline" style={{ textDecoration: 'none', fontSize: '0.875rem', padding: '0.6rem 1.2rem' }}>Manage Students</Link>
        </div>
      </div>

      {/* Stats Grid */}
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))', gap: '1.5rem', marginBottom: '2rem' }}>
        {stats.map((s, i) => (
          <div key={i} className="glass-panel admin-card" style={{ padding: '1.5rem' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
              <div style={{ width: '48px', height: '48px', borderRadius: '12px', background: `${s.color}22`, color: s.color, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>{s.icon}</div>
              <div>
                <div style={{ fontSize: '1.5rem', fontWeight: '800', color: 'white' }}>{s.value}</div>
                <div style={{ fontSize: '0.75rem', color: '#94a3b8' }}>{s.label}</div>
              </div>
            </div>
            <div style={{ marginTop: '0.75rem', fontSize: '0.75rem', color: s.color, borderTop: '1px solid rgba(255,255,255,0.1)', paddingTop: '0.75rem' }}>{s.change}</div>
          </div>
        ))}
      </div>

      {/* Alert Banner */}
      <div className="glass-panel admin-card" style={{ padding: '1rem 1.5rem', marginBottom: '1.5rem', display: 'flex', alignItems: 'center', gap: '1rem', background: 'rgba(251,191,36,0.1)', border: '1px solid rgba(251,191,36,0.3)' }}>
        <AlertTriangle size={20} color="#fbbf24" />
        <p style={{ margin: 0, fontSize: '0.9rem', color: '#fde68a' }}>
          <strong>7 applications</strong> flagged for urgent review — deadline in 3 days.
          <Link to="/admin/applications" style={{ color: '#fbbf24', marginLeft: '0.5rem', textDecoration: 'underline' }}>Review now →</Link>
        </p>
      </div>

      {/* Recent Applications Table */}
      <div className="glass-panel admin-card" style={{ padding: '1.5rem' }}>
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1.5rem' }}>
          <h2 style={{ fontSize: '1.1rem', fontWeight: '600', margin: 0 }}>Recent Applications</h2>
          <Link to="/admin/applications" style={{ color: '#60a5fa', fontSize: '0.85rem', textDecoration: 'none' }}>View all →</Link>
        </div>
        <div style={{ overflowX: 'auto' }}>
          <table className="glass-table">
            <thead>
              <tr><th>App ID</th><th>Student</th><th>Course</th><th>Amount</th><th>Status</th><th>Date</th><th>Action</th></tr>
            </thead>
            <tbody>
              {recentApps.map(a => (
                <tr key={a.id}>
                  <td style={{ color: '#60a5fa', fontWeight: '500' }}>{a.id}</td>
                  <td style={{ fontWeight: '500' }}>{a.name}</td>
                  <td style={{ color: '#94a3b8', fontSize: '0.85rem' }}>{a.course}</td>
                  <td>{a.amount}</td>
                  <td><span className={`status-badge status-${a.status}`}>{a.status}</span></td>
                  <td style={{ color: '#64748b', fontSize: '0.85rem' }}>{a.date}</td>
                  <td>
                    <Link to="/admin/applications" style={{ color: '#60a5fa', fontSize: '0.8rem', textDecoration: 'none' }}>Review</Link>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}
