import React, { useEffect, useRef } from 'react';
import { gsap } from 'gsap';
import { CheckCircle, Clock, XCircle, FileText, MessageSquare } from 'lucide-react';

const timeline = [
  { label: 'Application Submitted', date: '2026-05-01', done: true, desc: 'Your application APP-2026-002 has been successfully received.' },
  { label: 'Initial Review', date: '2026-05-03', done: true, desc: 'Documents verified by the bursary office. Application is complete.' },
  { label: 'Committee Review', date: '2026-05-10', done: false, desc: 'Your application is being reviewed by the bursary committee.' },
  { label: 'Decision Made', date: 'Pending', done: false, desc: 'Final approval or rejection communicated via email and portal.' },
  { label: 'Funds Disbursed', date: 'Pending', done: false, desc: 'Approved amount credited to your student account.' },
];

export default function Status() {
  const containerRef = useRef(null);

  useEffect(() => {
    gsap.fromTo('.status-card', { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.5, stagger: 0.1, ease: 'power3.out' });
    gsap.fromTo('.timeline-item', { opacity: 0, x: -20 }, { opacity: 1, x: 0, duration: 0.4, stagger: 0.12, ease: 'power2.out', delay: 0.3 });
  }, []);

  return (
    <div className="container page-container" ref={containerRef}>
      <h1 style={{ fontSize: '1.75rem', fontWeight: '700', marginBottom: '0.5rem' }}>Application Status</h1>
      <p style={{ color: '#94a3b8', marginBottom: '2rem' }}>Track the progress of your bursary applications in real time.</p>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '1.5rem', marginBottom: '2.5rem' }}>
        {[
          { icon: <FileText size={22} />, label: 'Application ID', value: 'APP-2026-002', color: '#60a5fa' },
          { icon: <Clock size={22} />, label: 'Status', value: 'Under Review', color: '#fbbf24' },
          { icon: <CheckCircle size={22} />, label: 'Submitted', value: '2026-05-01', color: '#34d399' },
          { icon: <MessageSquare size={22} />, label: 'Est. Decision', value: '2026-05-17', color: '#a78bfa' },
        ].map((c, i) => (
          <div key={i} className="glass-panel status-card" style={{ padding: '1.5rem', display: 'flex', alignItems: 'center', gap: '1rem' }}>
            <div style={{ width: '44px', height: '44px', borderRadius: '12px', background: `${c.color}22`, color: c.color, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>{c.icon}</div>
            <div>
              <div style={{ fontSize: '1rem', fontWeight: '700', color: 'white' }}>{c.value}</div>
              <div style={{ fontSize: '0.75rem', color: '#94a3b8' }}>{c.label}</div>
            </div>
          </div>
        ))}
      </div>

      <div className="glass-panel" style={{ padding: '2rem' }}>
        <h2 style={{ fontSize: '1.1rem', fontWeight: '600', marginBottom: '2rem' }}>Application Progress Timeline</h2>
        <div style={{ position: 'relative', paddingLeft: '2rem' }}>
          {/* Vertical line */}
          <div style={{ position: 'absolute', left: '11px', top: '12px', bottom: '12px', width: '2px', background: 'rgba(255,255,255,0.1)' }} />
          {timeline.map((item, i) => (
            <div key={i} className="timeline-item" style={{ display: 'flex', gap: '1.5rem', marginBottom: i < timeline.length - 1 ? '2rem' : 0, position: 'relative' }}>
              <div style={{
                position: 'absolute', left: '-2rem', top: '2px',
                width: '24px', height: '24px', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0,
                background: item.done ? '#34d399' : 'rgba(255,255,255,0.1)',
                border: item.done ? 'none' : '2px solid rgba(255,255,255,0.2)',
                zIndex: 1,
              }}>
                {item.done ? <CheckCircle size={14} color="white" fill="white" /> : <div style={{ width: '8px', height: '8px', borderRadius: '50%', background: '#64748b' }} />}
              </div>
              <div style={{ flex: 1 }}>
                <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '0.25rem' }}>
                  <span style={{ fontWeight: '600', color: item.done ? 'white' : '#64748b' }}>{item.label}</span>
                  <span style={{ fontSize: '0.8rem', color: '#64748b' }}>{item.date}</span>
                </div>
                <p style={{ color: item.done ? '#94a3b8' : '#475569', fontSize: '0.875rem', margin: 0 }}>{item.desc}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
