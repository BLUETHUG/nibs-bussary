import React, { useState } from 'react';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import { GraduationCap, Home, LogIn, LayoutDashboard, FileText, UserCircle, Settings, Mail, Users, LogOut, Menu, X } from 'lucide-react';

export default function Navbar() {
  const location = useLocation();
  const path = location.pathname;
  const navigate = useNavigate();
  const [mobileOpen, setMobileOpen] = useState(false);

  // Detect the section from URL
  const isStudentArea = path.startsWith('/student');
  const isAdminArea = path.startsWith('/admin');
  const isLoggedIn = isStudentArea || isAdminArea;

  const handleLogout = () => {
    navigate('/login');
    setMobileOpen(false);
  };

  const navLinks = isAdminArea ? [
    { to: '/admin/dashboard', icon: <Settings size={17} />, label: 'Dashboard' },
    { to: '/admin/applications', icon: <FileText size={17} />, label: 'Applications' },
    { to: '/admin/students', icon: <Users size={17} />, label: 'Students' },
  ] : isStudentArea ? [
    { to: '/student/dashboard', icon: <LayoutDashboard size={17} />, label: 'Dashboard' },
    { to: '/student/apply', icon: <FileText size={17} />, label: 'Apply' },
    { to: '/student/status', icon: <FileText size={17} />, label: 'Status' },
    { to: '/student/profile', icon: <UserCircle size={17} />, label: 'Profile' },
  ] : [
    { to: '/', icon: <Home size={17} />, label: 'Home' },
    { to: '/contact', icon: <Mail size={17} />, label: 'Contact' },
  ];

  return (
    <nav className="glass-nav">
      <div className="container" style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', height: '72px' }}>
        {/* Logo */}
        <Link to="/" style={{ display: 'flex', alignItems: 'center', gap: '0.75rem', textDecoration: 'none', color: 'white' }}>
          <div style={{ background: 'linear-gradient(135deg,#2563eb,#1d4ed8)', padding: '0.5rem', borderRadius: '10px', display: 'flex' }}>
            <GraduationCap size={22} color="white" />
          </div>
          <div>
            <div style={{ fontSize: '1.1rem', fontWeight: '700', lineHeight: 1.1 }}>NIBS Bursary</div>
            {isAdminArea && <div style={{ fontSize: '0.65rem', color: '#60a5fa', fontWeight: '500', letterSpacing: '0.08em', textTransform: 'uppercase' }}>Admin Portal</div>}
            {isStudentArea && <div style={{ fontSize: '0.65rem', color: '#34d399', fontWeight: '500', letterSpacing: '0.08em', textTransform: 'uppercase' }}>Student Portal</div>}
          </div>
        </Link>

        {/* Desktop Nav */}
        <div style={{ display: 'flex', gap: '0.25rem', alignItems: 'center' }}>
          {navLinks.map(({ to, icon, label }) => {
            const active = path === to || (to !== '/' && path.startsWith(to));
            return (
              <Link key={to} to={to} onClick={() => setMobileOpen(false)} style={{
                display: 'flex', alignItems: 'center', gap: '0.4rem', textDecoration: 'none',
                padding: '0.5rem 0.875rem', borderRadius: '8px', fontSize: '0.875rem', fontWeight: '500',
                transition: 'all 0.2s',
                background: active ? 'rgba(37,99,235,0.25)' : 'transparent',
                color: active ? '#93c5fd' : '#94a3b8',
              }}>
                {icon} {label}
              </Link>
            );
          })}

          {!isLoggedIn && <Link to="/contact" style={{ display: 'flex', alignItems: 'center', gap: '0.4rem', textDecoration: 'none', padding: '0.5rem 0.875rem', borderRadius: '8px', fontSize: '0.875rem', fontWeight: '500', color: path === '/contact' ? '#93c5fd' : '#94a3b8', background: path === '/contact' ? 'rgba(37,99,235,0.25)' : 'transparent' }}><Mail size={17} /> Contact</Link>}

          <div style={{ width: '1px', height: '24px', background: 'rgba(255,255,255,0.1)', margin: '0 0.5rem' }} />

          {isLoggedIn ? (
            <button id="logout-btn" onClick={handleLogout} style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', background: 'rgba(239,68,68,0.15)', border: '1px solid rgba(239,68,68,0.3)', borderRadius: '8px', color: '#f87171', padding: '0.5rem 0.875rem', cursor: 'pointer', fontFamily: 'inherit', fontSize: '0.875rem', fontWeight: '500' }}>
              <LogOut size={16} /> Logout
            </button>
          ) : (
            <div style={{ display: 'flex', gap: '0.5rem' }}>
              <Link to="/login" id="nav-login" className="btn btn-outline" style={{ padding: '0.5rem 1rem', fontSize: '0.875rem', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '0.4rem' }}>
                <LogIn size={16} /> Login
              </Link>
              <Link to="/register" id="nav-register" className="btn btn-primary" style={{ padding: '0.5rem 1rem', fontSize: '0.875rem', textDecoration: 'none' }}>
                Register
              </Link>
            </div>
          )}
        </div>
      </div>
    </nav>
  );
}
