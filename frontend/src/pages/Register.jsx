import React, { useEffect, useRef, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { gsap } from 'gsap';
import { GraduationCap, Mail, Lock, User, Phone, BookOpen } from 'lucide-react';
import { createUserWithEmailAndPassword } from 'firebase/auth';
import { auth, db } from '../firebase';
import { doc, setDoc, serverTimestamp } from 'firebase/firestore';

export default function Register() {
  const [form, setForm] = useState({ fullName: '', email: '', phone: '', admNo: '', course: '', password: '', confirm: '' });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const cardRef = useRef(null);
  const navigate = useNavigate();

  useEffect(() => {
    gsap.fromTo(cardRef.current, { opacity: 0, y: 40 }, { opacity: 1, y: 0, duration: 0.7, ease: 'power3.out' });
  }, []);

  const set = (k) => (e) => setForm(f => ({ ...f, [k]: e.target.value }));

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (form.password !== form.confirm) { setError('Passwords do not match.'); return; }
    setLoading(true); setError('');
    try {
      const cred = await createUserWithEmailAndPassword(auth, form.email, form.password);
      await setDoc(doc(db, 'users', cred.user.uid), {
        uid: cred.user.uid, fullName: form.fullName, email: form.email,
        phone: form.phone, admNo: form.admNo, course: form.course,
        role: 'student', createdAt: serverTimestamp(),
      });
      navigate('/student/dashboard');
    } catch (err) {
      setError(err.message || 'Registration failed.');
    }
    setLoading(false);
  };

  const Field = ({ id, icon, label, type = 'text', placeholder, val, onChange }) => (
    <div className="form-group">
      <label className="form-label">{label}</label>
      <div style={{ position: 'relative' }}>
        <span style={{ position: 'absolute', left: '0.875rem', top: '50%', transform: 'translateY(-50%)', color: '#64748b' }}>{icon}</span>
        <input id={id} type={type} className="form-input" placeholder={placeholder}
          style={{ paddingLeft: '2.75rem' }} value={val} onChange={onChange} required />
      </div>
    </div>
  );

  return (
    <div className="container page-container" style={{ display: 'flex', justifyContent: 'center', paddingTop: '3rem' }}>
      <div ref={cardRef} className="glass-panel" style={{ width: '100%', maxWidth: '520px', padding: '2.5rem' }}>
        <div style={{ textAlign: 'center', marginBottom: '2rem' }}>
          <div style={{ display: 'inline-flex', background: 'var(--primary)', padding: '1rem', borderRadius: '16px', marginBottom: '1rem' }}>
            <GraduationCap size={32} color="white" />
          </div>
          <h1 style={{ fontSize: '1.75rem', fontWeight: '700', marginBottom: '0.25rem' }}>Create Account</h1>
          <p style={{ color: '#94a3b8', fontSize: '0.9rem' }}>Register to apply for NIBS Bursary</p>
        </div>

        {error && <div style={{ background: 'rgba(239,68,68,0.15)', border: '1px solid rgba(239,68,68,0.3)', borderRadius: '8px', padding: '0.75rem 1rem', marginBottom: '1.5rem', color: '#fca5a5', fontSize: '0.875rem' }}>{error}</div>}

        <form onSubmit={handleSubmit}>
          <Field id="reg-name" icon={<User size={18} />} label="Full Name" placeholder="John Kamau" val={form.fullName} onChange={set('fullName')} />
          <Field id="reg-email" icon={<Mail size={18} />} label="Email Address" type="email" placeholder="john@example.com" val={form.email} onChange={set('email')} />
          <Field id="reg-phone" icon={<Phone size={18} />} label="Phone Number" placeholder="+254 700 000 000" val={form.phone} onChange={set('phone')} />
          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
            <Field id="reg-adm" icon={<BookOpen size={18} />} label="Admission No." placeholder="NIBS/2026/001" val={form.admNo} onChange={set('admNo')} />
            <div className="form-group">
              <label className="form-label">Course / Programme</label>
              <select id="reg-course" className="form-input" value={form.course} onChange={set('course')} required style={{ cursor: 'pointer' }}>
                <option value="">Select course</option>
                <option>Business Administration</option>
                <option>ICT</option>
                <option>Accounting &amp; Finance</option>
                <option>Journalism &amp; Media</option>
                <option>Hospitality Management</option>
                <option>Education</option>
              </select>
            </div>
          </div>
          <Field id="reg-pass" icon={<Lock size={18} />} label="Password" type="password" placeholder="Min. 8 characters" val={form.password} onChange={set('password')} />
          <Field id="reg-confirm" icon={<Lock size={18} />} label="Confirm Password" type="password" placeholder="Repeat password" val={form.confirm} onChange={set('confirm')} />

          <button id="reg-submit" type="submit" className="btn btn-primary" disabled={loading}
            style={{ width: '100%', fontSize: '1rem', padding: '0.875rem', marginTop: '0.5rem' }}>
            {loading ? 'Creating Account...' : 'Create Account'}
          </button>
        </form>
        <p style={{ textAlign: 'center', color: '#64748b', fontSize: '0.875rem', marginTop: '1.5rem' }}>
          Already have an account? <Link to="/login" style={{ color: '#60a5fa', textDecoration: 'none', fontWeight: '600' }}>Sign in</Link>
        </p>
      </div>
    </div>
  );
}
