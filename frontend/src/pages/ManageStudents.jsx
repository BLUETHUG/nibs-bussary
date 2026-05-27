import React, { useEffect, useRef, useState } from 'react';
import { gsap } from 'gsap';
import { Search, UserX, Eye, Mail } from 'lucide-react';

const students = [
  { uid: '1', name: 'Alice Wanjiku', email: 'alice@example.com', adm: 'NIBS/2026/010', course: 'ICT', year: 'Year 1', applications: 1, status: 'active' },
  { uid: '2', name: 'Brian Odhiambo', email: 'brian@example.com', adm: 'NIBS/2026/009', course: 'Business Admin', year: 'Year 2', applications: 2, status: 'active' },
  { uid: '3', name: 'Carol Muthoni', email: 'carol@example.com', adm: 'NIBS/2026/008', course: 'Accounting', year: 'Year 3', applications: 1, status: 'inactive' },
  { uid: '4', name: 'David Kipchoge', email: 'david@example.com', adm: 'NIBS/2026/007', course: 'Journalism', year: 'Year 2', applications: 1, status: 'active' },
  { uid: '5', name: 'Eve Achieng', email: 'eve@example.com', adm: 'NIBS/2026/006', course: 'Education', year: 'Year 1', applications: 2, status: 'active' },
  { uid: '6', name: 'Frank Mutua', email: 'frank@example.com', adm: 'NIBS/2026/005', course: 'ICT', year: 'Year 3', applications: 1, status: 'active' },
];

export default function ManageStudents() {
  const [search, setSearch] = useState('');
  const [selected, setSelected] = useState(null);
  const containerRef = useRef(null);

  useEffect(() => {
    gsap.fromTo(containerRef.current, { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.6, ease: 'power3.out' });
  }, []);

  const filtered = students.filter(s =>
    s.name.toLowerCase().includes(search.toLowerCase()) ||
    s.adm.toLowerCase().includes(search.toLowerCase()) ||
    s.email.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <div className="container page-container" ref={containerRef}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '2rem', flexWrap: 'wrap', gap: '1rem' }}>
        <div>
          <h1 style={{ fontSize: '1.75rem', fontWeight: '700', margin: 0 }}>Manage Students</h1>
          <p style={{ color: '#94a3b8', marginTop: '0.25rem' }}>View and manage registered student accounts.</p>
        </div>
        <div style={{ background: 'rgba(96,165,250,0.1)', borderRadius: '12px', padding: '0.75rem 1.5rem', border: '1px solid rgba(96,165,250,0.2)' }}>
          <span style={{ color: '#60a5fa', fontWeight: '700', fontSize: '1.25rem' }}>{students.length}</span>
          <span style={{ color: '#94a3b8', fontSize: '0.875rem', marginLeft: '0.5rem' }}>Registered Students</span>
        </div>
      </div>

      <div style={{ position: 'relative', marginBottom: '1.5rem' }}>
        <Search size={18} style={{ position: 'absolute', left: '0.875rem', top: '50%', transform: 'translateY(-50%)', color: '#64748b' }} />
        <input id="students-search" type="text" className="form-input" placeholder="Search by name, admission number, or email..."
          style={{ paddingLeft: '2.75rem', maxWidth: '480px' }} value={search} onChange={e => setSearch(e.target.value)} />
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: selected ? '1fr 360px' : '1fr', gap: '1.5rem' }}>
        <div className="glass-panel" style={{ padding: '1.5rem', overflowX: 'auto' }}>
          <table className="glass-table">
            <thead>
              <tr><th>Student</th><th>Admission No.</th><th>Course</th><th>Year</th><th>Applications</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
              {filtered.map(s => (
                <tr key={s.uid} style={{ cursor: 'pointer' }} onClick={() => setSelected(s)}>
                  <td>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '0.75rem' }}>
                      <div style={{ width: '36px', height: '36px', borderRadius: '50%', background: 'linear-gradient(135deg,#2563eb,#10b981)', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '0.875rem', flexShrink: 0 }}>
                        {s.name.charAt(0)}
                      </div>
                      <div>
                        <div style={{ fontWeight: '500' }}>{s.name}</div>
                        <div style={{ fontSize: '0.75rem', color: '#64748b' }}>{s.email}</div>
                      </div>
                    </div>
                  </td>
                  <td style={{ color: '#60a5fa', fontSize: '0.875rem' }}>{s.adm}</td>
                  <td style={{ color: '#94a3b8', fontSize: '0.875rem' }}>{s.course}</td>
                  <td style={{ fontSize: '0.875rem' }}>{s.year}</td>
                  <td style={{ textAlign: 'center' }}>
                    <span style={{ background: 'rgba(96,165,250,0.15)', color: '#60a5fa', padding: '0.2rem 0.6rem', borderRadius: '9999px', fontSize: '0.8rem', fontWeight: '600' }}>{s.applications}</span>
                  </td>
                  <td><span className={`status-badge ${s.status === 'active' ? 'status-approved' : 'status-rejected'}`}>{s.status}</span></td>
                  <td>
                    <div style={{ display: 'flex', gap: '0.5rem' }} onClick={e => e.stopPropagation()}>
                      <button id={`view-student-${s.uid}`} title="View" onClick={() => setSelected(s)} style={{ background: 'rgba(96,165,250,0.2)', border: 'none', color: '#60a5fa', padding: '0.35rem', borderRadius: '6px', cursor: 'pointer' }}><Eye size={16} /></button>
                      <button id={`email-student-${s.uid}`} title="Send email" onClick={() => window.open(`mailto:${s.email}`)} style={{ background: 'rgba(167,139,250,0.2)', border: 'none', color: '#a78bfa', padding: '0.35rem', borderRadius: '6px', cursor: 'pointer' }}><Mail size={16} /></button>
                    </div>
                  </td>
                </tr>
              ))}
              {filtered.length === 0 && <tr><td colSpan={7} style={{ textAlign: 'center', color: '#64748b', padding: '2rem' }}>No students found.</td></tr>}
            </tbody>
          </table>
        </div>

        {selected && (
          <div className="glass-panel" style={{ padding: '1.5rem', alignSelf: 'start' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '1.5rem' }}>
              <h3 style={{ margin: 0, fontWeight: '600' }}>Student Profile</h3>
              <button onClick={() => setSelected(null)} style={{ background: 'none', border: 'none', color: '#64748b', cursor: 'pointer', fontSize: '1.2rem' }}>×</button>
            </div>
            <div style={{ textAlign: 'center', marginBottom: '1.5rem' }}>
              <div style={{ width: '64px', height: '64px', borderRadius: '50%', background: 'linear-gradient(135deg,#2563eb,#10b981)', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '1.5rem', margin: '0 auto 0.75rem' }}>
                {selected.name.charAt(0)}
              </div>
              <div style={{ fontWeight: '700', fontSize: '1.1rem' }}>{selected.name}</div>
              <div style={{ color: '#64748b', fontSize: '0.85rem', marginTop: '0.25rem' }}>{selected.email}</div>
            </div>
            {[['Admission No.', selected.adm], ['Course', selected.course], ['Year of Study', selected.year], ['Applications', selected.applications], ['Account Status', selected.status]].map(([k, v]) => (
              <div key={k} style={{ display: 'flex', justifyContent: 'space-between', padding: '0.6rem 0', borderBottom: '1px solid rgba(255,255,255,0.07)', fontSize: '0.875rem' }}>
                <span style={{ color: '#94a3b8' }}>{k}</span>
                <span style={{ fontWeight: '500' }}>{k === 'Account Status' ? <span className={`status-badge ${v === 'active' ? 'status-approved' : 'status-rejected'}`}>{v}</span> : v}</span>
              </div>
            ))}
            <button id="contact-student" className="btn btn-outline" style={{ width: '100%', marginTop: '1.5rem', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '0.5rem' }} onClick={() => window.open(`mailto:${selected.email}`)}>
              <Mail size={16} /> Send Email
            </button>
          </div>
        )}
      </div>
    </div>
  );
}
