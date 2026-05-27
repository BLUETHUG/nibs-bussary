import React, { useEffect, useRef, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { gsap } from 'gsap';
import { GraduationCap, Mail, Lock, Eye, EyeOff, Shield, User } from 'lucide-react';
import { signInWithEmailAndPassword } from 'firebase/auth';
import { auth, db } from '../firebase';
import { doc, getDoc } from 'firebase/firestore';

export default function Login() {
  const [role, setRole] = useState('student');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [showPass, setShowPass] = useState(false);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const cardRef = useRef(null);
  const navigate = useNavigate();

  useEffect(() => {
    gsap.fromTo(cardRef.current,
      { opacity: 0, y: 40, scale: 0.97 },
      { opacity: 1, y: 0, scale: 1, duration: 0.7, ease: 'power3.out' }
    );
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    try {
      const cred = await signInWithEmailAndPassword(auth, email, password);
      const userDoc = await getDoc(doc(db, 'users', cred.user.uid));
      const userData = userDoc.data();
      if (userData?.role === 'admin') {
        navigate('/admin/dashboard');
      } else {
        navigate('/student/dashboard');
      }
    } catch (err) {
      setError(err.message || 'Login failed. Check your credentials.');
    }
    setLoading(false);
  };

  return (
    <div className="container page-container" style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', minHeight: '85vh' }}>
      <div ref={cardRef} className="glass-panel" style={{ width: '100%', maxWidth: '460px', padding: '2.5rem' }}>
        {/* Logo */}
        <div style={{ textAlign: 'center', marginBottom: '2rem' }}>
          <div style={{ display: 'inline-flex', background: 'var(--primary)', padding: '1rem', borderRadius: '16px', marginBottom: '1rem' }}>
            <GraduationCap size={32} color="white" />
          </div>
          <h1 style={{ fontSize: '1.75rem', fontWeight: '700', marginBottom: '0.25rem' }}>Welcome Back</h1>
          <p style={{ color: '#94a3b8', fontSize: '0.9rem' }}>Sign in to your NIBS Bursary account</p>
        </div>

        {/* Role Toggle */}
        <div style={{ display: 'flex', background: 'rgba(0,0,0,0.2)', borderRadius: '12px', padding: '0.25rem', marginBottom: '2rem' }}>
          {[{ val: 'student', label: 'Student', icon: <User size={16} /> }, { val: 'admin', label: 'Admin', icon: <Shield size={16} /> }].map(({ val, label, icon }) => (
            <button key={val} onClick={() => setRole(val)} style={{
              flex: 1, display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '0.5rem',
              padding: '0.6rem', borderRadius: '10px', border: 'none', cursor: 'pointer', fontFamily: 'inherit',
              fontWeight: '600', fontSize: '0.875rem', transition: 'all 0.2s',
              background: role === val ? 'var(--primary)' : 'transparent',
              color: role === val ? 'white' : '#94a3b8',
            }}>
              {icon} {label}
            </button>
          ))}
        </div>

        {error && (
          <div style={{ background: 'rgba(239,68,68,0.15)', border: '1px solid rgba(239,68,68,0.3)', borderRadius: '8px', padding: '0.75rem 1rem', marginBottom: '1.5rem', color: '#fca5a5', fontSize: '0.875rem' }}>
            {error}
          </div>
        )}

        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label className="form-label">Email Address</label>
            <div style={{ position: 'relative' }}>
              <Mail size={18} style={{ position: 'absolute', left: '0.875rem', top: '50%', transform: 'translateY(-50%)', color: '#64748b' }} />
              <input id="login-email" type="email" className="form-input" placeholder="you@example.com"
                style={{ paddingLeft: '2.75rem' }} value={email} onChange={e => setEmail(e.target.value)} required />
            </div>
          </div>

          <div className="form-group">
            <label className="form-label">Password</label>
            <div style={{ position: 'relative' }}>
              <Lock size={18} style={{ position: 'absolute', left: '0.875rem', top: '50%', transform: 'translateY(-50%)', color: '#64748b' }} />
              <input id="login-password" type={showPass ? 'text' : 'password'} className="form-input" placeholder="••••••••"
                style={{ paddingLeft: '2.75rem', paddingRight: '2.75rem' }} value={password} onChange={e => setPassword(e.target.value)} required />
              <button type="button" onClick={() => setShowPass(!showPass)} style={{ position: 'absolute', right: '0.875rem', top: '50%', transform: 'translateY(-50%)', background: 'none', border: 'none', cursor: 'pointer', color: '#64748b' }}>
                {showPass ? <EyeOff size={18} /> : <Eye size={18} />}
              </button>
            </div>
          </div>

          <button id="login-submit" type="submit" className="btn btn-primary" disabled={loading}
            style={{ width: '100%', fontSize: '1rem', padding: '0.875rem', marginTop: '0.5rem' }}>
            {loading ? 'Signing in...' : `Sign In as ${role === 'admin' ? 'Admin' : 'Student'}`}
          </button>
        </form>

        <p style={{ textAlign: 'center', color: '#64748b', fontSize: '0.875rem', marginTop: '1.5rem' }}>
          Don't have an account? <Link to="/register" style={{ color: '#60a5fa', textDecoration: 'none', fontWeight: '600' }}>Register here</Link>
        </p>
      </div>
    </div>
  );
}
