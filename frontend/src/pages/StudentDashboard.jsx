import React, { useEffect, useRef, useState } from 'react';
import { Link } from 'react-router-dom';
import { gsap } from 'gsap';
import { FileText, Clock, CheckCircle, XCircle, Bell, TrendingUp, BookOpen } from 'lucide-react';

const mockApplications = [
  { id: 'APP-2026-001', type: 'Full Bursary', amount: 'KSh 45,000', status: 'approved', date: '2026-03-15', semester: 'Sem 1 2026' },
  { id: 'APP-2026-002', type: 'Partial Bursary', amount: 'KSh 20,000', status: 'pending', date: '2026-05-01', semester: 'Sem 2 2026' },
];

const mockNotifications = [
  { msg: 'Your application APP-2026-001 has been approved!', time: '2 days ago', type: 'success' },
  { msg: 'Please upload your latest fee statement.', time: '5 days ago', type: 'info' },
];

export default function StudentDashboard() {
  const [activeTab, setActiveTab] = useState('overview');
  const containerRef = useRef(null);

  useEffect(() => {
    gsap.fromTo('.dash-card', { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.5, stagger: 0.1, ease: 'power3.out' });
  }, []);

  const stats = [
    { icon: <FileText size={22} />, label: 'Total Applications', value: '2', color: '#60a5fa' },
    { icon: <CheckCircle size={22} />, label: 'Approved', value: '1', color: '#34d399' },
    { icon: <Clock size={22} />, label: 'Pending Review', value: '1', color: '#fbbf24' },
    { icon: <TrendingUp size={22} />, label: 'Total Received', value: 'KSh 45K', color: '#a78bfa' },
  ];

  return (
    <div className="container page-container" ref={containerRef}>
      <div style={{ marginBottom: '2rem' }}>
        <h1 style={{ fontSize: '1.75rem', fontWeight: '700' }}>Student Dashboard</h1>
        <p style={{ color: '#94a3b8' }}>Welcome back! Here's your bursary overview.</p>
      </div>

      {/* Stat Cards */}
      <div className="dashboard-grid" style={{ gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))', marginBottom: '2rem' }}>
        {stats.map((s, i) => (
          <div key={i} className="glass-panel stat-card dash-card" style={{ padding: '1.5rem', display: 'flex', alignItems: 'center', gap: '1rem' }}>
            <div style={{ width: '48px', height: '48px', borderRadius: '12px', background: `${s.color}22`, color: s.color, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>{s.icon}</div>
            <div>
              <div style={{ fontSize: '1.5rem', fontWeight: '700', color: 'white' }}>{s.value}</div>
              <div style={{ fontSize: '0.8rem', color: '#94a3b8' }}>{s.label}</div>
            </div>
          </div>
        ))}
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr', gap: '1.5rem', flexWrap: 'wrap' }}>
        {/* Applications Table */}
        <div className="glass-panel dash-card" style={{ padding: '1.5rem' }}>
          <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1.5rem' }}>
            <h2 style={{ fontSize: '1.1rem', fontWeight: '600', margin: 0 }}>My Applications</h2>
            <Link to="/student/apply" className="btn btn-primary" style={{ padding: '0.5rem 1rem', fontSize: '0.8rem', textDecoration: 'none' }}>+ New Application</Link>
          </div>
          <table className="glass-table">
            <thead>
              <tr>
                <th>ID</th><th>Type</th><th>Amount</th><th>Status</th><th>Date</th>
              </tr>
            </thead>
            <tbody>
              {mockApplications.map((a) => (
                <tr key={a.id}>
                  <td style={{ color: '#60a5fa', fontWeight: '500' }}>{a.id}</td>
                  <td>{a.type}</td>
                  <td>{a.amount}</td>
                  <td><span className={`status-badge status-${a.status}`}>{a.status}</span></td>
                  <td style={{ color: '#94a3b8', fontSize: '0.85rem' }}>{a.date}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        {/* Notifications */}
        <div className="glass-panel dash-card" style={{ padding: '1.5rem' }}>
          <h2 style={{ fontSize: '1.1rem', fontWeight: '600', marginBottom: '1.5rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
            <Bell size={18} /> Notifications
          </h2>
          <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
            {mockNotifications.map((n, i) => (
              <div key={i} style={{ padding: '0.875rem', borderRadius: '8px', background: n.type === 'success' ? 'rgba(52,211,153,0.1)' : 'rgba(96,165,250,0.1)', borderLeft: `3px solid ${n.type === 'success' ? '#34d399' : '#60a5fa'}` }}>
                <p style={{ fontSize: '0.85rem', color: 'white', margin: 0 }}>{n.msg}</p>
                <span style={{ fontSize: '0.75rem', color: '#64748b', marginTop: '0.25rem', display: 'block' }}>{n.time}</span>
              </div>
            ))}
          </div>
          <Link to="/student/status" style={{ display: 'block', textAlign: 'center', color: '#60a5fa', fontSize: '0.85rem', marginTop: '1.5rem', textDecoration: 'none' }}>View Full Status →</Link>
        </div>
      </div>
    </div>
  );
}
