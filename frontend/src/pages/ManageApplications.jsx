import React, { useEffect, useRef, useState } from 'react';
import { gsap } from 'gsap';
import { Search, CheckCircle, XCircle, Eye, Filter } from 'lucide-react';

const allApps = [
  { id: 'APP-2026-010', name: 'Alice Wanjiku', adm: 'NIBS/2026/010', course: 'ICT', amount: 'KSh 30,000', income: 'Below KSh 10,000', status: 'pending', date: '2026-05-25' },
  { id: 'APP-2026-009', name: 'Brian Odhiambo', adm: 'NIBS/2026/009', course: 'Business Admin', amount: 'KSh 45,000', income: 'Below KSh 10,000', status: 'approved', date: '2026-05-23' },
  { id: 'APP-2026-008', name: 'Carol Muthoni', adm: 'NIBS/2026/008', course: 'Accounting', amount: 'KSh 20,000', income: 'KSh 10,000–30,000', status: 'rejected', date: '2026-05-20' },
  { id: 'APP-2026-007', name: 'David Kipchoge', adm: 'NIBS/2026/007', course: 'Journalism', amount: 'KSh 35,000', income: 'Below KSh 10,000', status: 'pending', date: '2026-05-18' },
  { id: 'APP-2026-006', name: 'Eve Achieng', adm: 'NIBS/2026/006', course: 'Education', amount: 'KSh 40,000', income: 'Below KSh 10,000', status: 'approved', date: '2026-05-16' },
  { id: 'APP-2026-005', name: 'Frank Mutua', adm: 'NIBS/2026/005', course: 'ICT', amount: 'KSh 25,000', income: 'KSh 10,000–30,000', status: 'pending', date: '2026-05-14' },
];

export default function ManageApplications() {
  const [search, setSearch] = useState('');
  const [filter, setFilter] = useState('all');
  const [selected, setSelected] = useState(null);
  const containerRef = useRef(null);

  useEffect(() => {
    gsap.fromTo(containerRef.current, { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.6, ease: 'power3.out' });
  }, []);

  const filtered = allApps.filter(a =>
    (filter === 'all' || a.status === filter) &&
    (a.name.toLowerCase().includes(search.toLowerCase()) || a.id.toLowerCase().includes(search.toLowerCase()))
  );

  const handleAction = (app, action) => {
    alert(`Application ${app.id} marked as "${action}". In production this would update Firebase Firestore.`);
    setSelected(null);
  };

  return (
    <div className="container page-container" ref={containerRef}>
      <h1 style={{ fontSize: '1.75rem', fontWeight: '700', marginBottom: '0.5rem' }}>Manage Applications</h1>
      <p style={{ color: '#94a3b8', marginBottom: '2rem' }}>Review, approve, or reject student bursary applications.</p>

      {/* Search & Filter */}
      <div style={{ display: 'flex', gap: '1rem', marginBottom: '1.5rem', flexWrap: 'wrap' }}>
        <div style={{ position: 'relative', flex: 1, minWidth: '200px' }}>
          <Search size={18} style={{ position: 'absolute', left: '0.875rem', top: '50%', transform: 'translateY(-50%)', color: '#64748b' }} />
          <input id="apps-search" type="text" className="form-input" placeholder="Search by name or ID..."
            style={{ paddingLeft: '2.75rem' }} value={search} onChange={e => setSearch(e.target.value)} />
        </div>
        <div style={{ display: 'flex', gap: '0.5rem' }}>
          {['all', 'pending', 'approved', 'rejected'].map(f => (
            <button key={f} id={`filter-${f}`} onClick={() => setFilter(f)} className="btn"
              style={{ padding: '0.5rem 1rem', fontSize: '0.8rem', textTransform: 'capitalize',
                background: filter === f ? 'var(--primary)' : 'rgba(255,255,255,0.1)', border: 'none',
                color: filter === f ? 'white' : '#94a3b8' }}>
              {f}
            </button>
          ))}
        </div>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: selected ? '1fr 380px' : '1fr', gap: '1.5rem' }}>
        {/* Table */}
        <div className="glass-panel" style={{ padding: '1.5rem', overflowX: 'auto' }}>
          <table className="glass-table">
            <thead>
              <tr><th>ID</th><th>Student</th><th>Course</th><th>Amount</th><th>Income</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
              {filtered.map(a => (
                <tr key={a.id} style={{ cursor: 'pointer' }} onClick={() => setSelected(a)}>
                  <td style={{ color: '#60a5fa', fontWeight: '500' }}>{a.id}</td>
                  <td><div style={{ fontWeight: '500' }}>{a.name}</div><div style={{ fontSize: '0.75rem', color: '#64748b' }}>{a.adm}</div></td>
                  <td style={{ fontSize: '0.875rem', color: '#94a3b8' }}>{a.course}</td>
                  <td style={{ fontWeight: '500' }}>{a.amount}</td>
                  <td style={{ fontSize: '0.8rem', color: '#94a3b8' }}>{a.income}</td>
                  <td><span className={`status-badge status-${a.status}`}>{a.status}</span></td>
                  <td>
                    <div style={{ display: 'flex', gap: '0.5rem' }} onClick={e => e.stopPropagation()}>
                      {a.status === 'pending' && <>
                        <button id={`approve-${a.id}`} title="Approve" onClick={() => handleAction(a, 'approved')} style={{ background: 'rgba(52,211,153,0.2)', border: 'none', color: '#34d399', padding: '0.35rem', borderRadius: '6px', cursor: 'pointer' }}><CheckCircle size={16} /></button>
                        <button id={`reject-${a.id}`} title="Reject" onClick={() => handleAction(a, 'rejected')} style={{ background: 'rgba(248,113,113,0.2)', border: 'none', color: '#f87171', padding: '0.35rem', borderRadius: '6px', cursor: 'pointer' }}><XCircle size={16} /></button>
                      </>}
                      <button id={`view-${a.id}`} title="View details" onClick={() => setSelected(a)} style={{ background: 'rgba(96,165,250,0.2)', border: 'none', color: '#60a5fa', padding: '0.35rem', borderRadius: '6px', cursor: 'pointer' }}><Eye size={16} /></button>
                    </div>
                  </td>
                </tr>
              ))}
              {filtered.length === 0 && <tr><td colSpan={7} style={{ textAlign: 'center', color: '#64748b', padding: '2rem' }}>No applications found.</td></tr>}
            </tbody>
          </table>
        </div>

        {/* Detail Panel */}
        {selected && (
          <div className="glass-panel" style={{ padding: '1.5rem', alignSelf: 'start' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '1.5rem' }}>
              <h3 style={{ fontSize: '1rem', fontWeight: '600', margin: 0 }}>Application Details</h3>
              <button onClick={() => setSelected(null)} style={{ background: 'none', border: 'none', color: '#64748b', cursor: 'pointer', fontSize: '1.2rem' }}>×</button>
            </div>
            {[['ID', selected.id], ['Student', selected.name], ['Admission', selected.adm], ['Course', selected.course], ['Amount Requested', selected.amount], ['Household Income', selected.income], ['Submitted', selected.date], ['Status', selected.status]].map(([k, v]) => (
              <div key={k} style={{ display: 'flex', justifyContent: 'space-between', padding: '0.6rem 0', borderBottom: '1px solid rgba(255,255,255,0.07)', fontSize: '0.875rem' }}>
                <span style={{ color: '#94a3b8' }}>{k}</span>
                <span style={{ fontWeight: '500' }}>{k === 'Status' ? <span className={`status-badge status-${v}`}>{v}</span> : v}</span>
              </div>
            ))}
            {selected.status === 'pending' && (
              <div style={{ display: 'flex', gap: '0.75rem', marginTop: '1.5rem' }}>
                <button id="detail-approve" className="btn" style={{ flex: 1, background: 'rgba(52,211,153,0.2)', color: '#34d399', border: '1px solid rgba(52,211,153,0.4)' }} onClick={() => handleAction(selected, 'approved')}>✓ Approve</button>
                <button id="detail-reject" className="btn" style={{ flex: 1, background: 'rgba(248,113,113,0.2)', color: '#f87171', border: '1px solid rgba(248,113,113,0.4)' }} onClick={() => handleAction(selected, 'rejected')}>✗ Reject</button>
              </div>
            )}
          </div>
        )}
      </div>
    </div>
  );
}
