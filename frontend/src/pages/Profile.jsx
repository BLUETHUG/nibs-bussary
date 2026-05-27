import React, { useEffect, useRef, useState } from 'react';
import { gsap } from 'gsap';
import { User, Mail, Phone, BookOpen, MapPin, Save } from 'lucide-react';

export default function Profile() {
  const containerRef = useRef(null);
  const [saved, setSaved] = useState(false);
  const [form, setForm] = useState({
    fullName: 'John Kamau', email: 'john.kamau@example.com', phone: '+254 712 345 678',
    dob: '2003-04-15', nationalId: '38291847', county: 'Nairobi',
    admNo: 'NIBS/2026/001', course: 'Business Administration', year: 'Year 2',
    guardian: 'Jane Kamau', guardianPhone: '+254 700 111 222',
  });

  useEffect(() => {
    gsap.fromTo(containerRef.current, { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.6, ease: 'power3.out' });
  }, []);

  const set = (k) => (e) => setForm(f => ({ ...f, [k]: e.target.value }));

  const handleSave = (e) => {
    e.preventDefault();
    setSaved(true);
    setTimeout(() => setSaved(false), 3000);
  };

  const Input = ({ id, label, val, onChange, type = 'text', readOnly = false }) => (
    <div className="form-group">
      <label className="form-label">{label}</label>
      <input id={id} type={type} className="form-input" value={val} onChange={onChange} readOnly={readOnly}
        style={readOnly ? { opacity: 0.6, cursor: 'not-allowed' } : {}} />
    </div>
  );

  return (
    <div className="container page-container" ref={containerRef}>
      <h1 style={{ fontSize: '1.75rem', fontWeight: '700', marginBottom: '0.5rem' }}>My Profile</h1>
      <p style={{ color: '#94a3b8', marginBottom: '2rem' }}>Manage your personal and academic information.</p>

      {saved && (
        <div style={{ background: 'rgba(52,211,153,0.15)', border: '1px solid rgba(52,211,153,0.3)', borderRadius: '8px', padding: '0.75rem 1rem', marginBottom: '1.5rem', color: '#34d399', fontSize: '0.875rem' }}>
          ✓ Profile updated successfully!
        </div>
      )}

      {/* Avatar */}
      <div className="glass-panel" style={{ padding: '2rem', marginBottom: '1.5rem', display: 'flex', alignItems: 'center', gap: '1.5rem' }}>
        <div style={{ width: '80px', height: '80px', borderRadius: '50%', background: 'linear-gradient(135deg, #2563eb, #10b981)', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '2rem', flexShrink: 0 }}>
          👤
        </div>
        <div>
          <h2 style={{ fontSize: '1.25rem', fontWeight: '700', margin: 0 }}>{form.fullName}</h2>
          <p style={{ color: '#94a3b8', margin: '0.25rem 0 0' }}>{form.admNo} · {form.course}</p>
          <span className="status-badge status-approved" style={{ display: 'inline-block', marginTop: '0.5rem' }}>Active Student</span>
        </div>
      </div>

      <form onSubmit={handleSave}>
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1.5rem' }}>
          <div className="glass-panel" style={{ padding: '2rem' }}>
            <h3 style={{ fontSize: '1rem', fontWeight: '600', marginBottom: '1.5rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
              <User size={18} color="#60a5fa" /> Personal Information
            </h3>
            <Input id="prof-name" label="Full Name" val={form.fullName} onChange={set('fullName')} />
            <Input id="prof-email" label="Email Address" type="email" val={form.email} onChange={set('email')} />
            <Input id="prof-phone" label="Phone Number" val={form.phone} onChange={set('phone')} />
            <Input id="prof-dob" label="Date of Birth" type="date" val={form.dob} onChange={set('dob')} />
            <Input id="prof-id" label="National ID" val={form.nationalId} onChange={set('nationalId')} readOnly />
            <Input id="prof-county" label="County" val={form.county} onChange={set('county')} />
          </div>
          <div className="glass-panel" style={{ padding: '2rem' }}>
            <h3 style={{ fontSize: '1rem', fontWeight: '600', marginBottom: '1.5rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
              <BookOpen size={18} color="#60a5fa" /> Academic & Guardian Info
            </h3>
            <Input id="prof-adm" label="Admission Number" val={form.admNo} onChange={set('admNo')} readOnly />
            <Input id="prof-course" label="Course" val={form.course} onChange={set('course')} readOnly />
            <Input id="prof-year" label="Year of Study" val={form.year} onChange={set('year')} />
            <Input id="prof-guardian" label="Guardian Name" val={form.guardian} onChange={set('guardian')} />
            <Input id="prof-gphone" label="Guardian Phone" val={form.guardianPhone} onChange={set('guardianPhone')} />
          </div>
        </div>
        <div style={{ marginTop: '1.5rem', display: 'flex', justifyContent: 'flex-end' }}>
          <button id="prof-save" type="submit" className="btn btn-primary" style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', padding: '0.875rem 2rem' }}>
            <Save size={18} /> Save Changes
          </button>
        </div>
      </form>
    </div>
  );
}
