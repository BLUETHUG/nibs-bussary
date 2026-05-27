import React, { useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
import { gsap } from 'gsap';
import { GraduationCap, BookOpen, Users, CheckCircle, ArrowRight, Star } from 'lucide-react';

const stats = [
  { value: '5,000+', label: 'Students Funded' },
  { value: 'KSh 120M+', label: 'Bursaries Awarded' },
  { value: '98%', label: 'Approval Rate' },
  { value: '50+', label: 'Partner Institutions' },
];

const features = [
  { icon: <BookOpen size={28} />, title: 'Easy Application', desc: 'Apply online in minutes with our streamlined digital form. No paperwork hassle.' },
  { icon: <CheckCircle size={28} />, title: 'Fast Processing', desc: 'Applications reviewed within 7 working days. Real-time status updates.' },
  { icon: <Users size={28} />, title: 'Expert Support', desc: 'Dedicated team ready to guide you through every step of the process.' },
  { icon: <Star size={28} />, title: 'Merit & Need Based', desc: 'Fair allocation process considering academic merit and financial need.' },
];

export default function Home() {
  const heroRef = useRef(null);
  const badgeRef = useRef(null);
  const h1Ref = useRef(null);
  const subRef = useRef(null);
  const btnRef = useRef(null);
  const statsRef = useRef(null);
  const featuresRef = useRef(null);

  useEffect(() => {
    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
    tl.fromTo(badgeRef.current, { opacity: 0, y: -20 }, { opacity: 1, y: 0, duration: 0.6 })
      .fromTo(h1Ref.current, { opacity: 0, y: 40 }, { opacity: 1, y: 0, duration: 0.8 }, '-=0.3')
      .fromTo(subRef.current, { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.6 }, '-=0.4')
      .fromTo(btnRef.current, { opacity: 0, scale: 0.9 }, { opacity: 1, scale: 1, duration: 0.5 }, '-=0.3');

    gsap.fromTo('.stat-card-item',
      { opacity: 0, y: 40 },
      { opacity: 1, y: 0, duration: 0.6, stagger: 0.15, ease: 'power3.out', delay: 0.8 }
    );

    gsap.fromTo('.feature-card',
      { opacity: 0, y: 50 },
      { opacity: 1, y: 0, duration: 0.6, stagger: 0.12, ease: 'power3.out', delay: 1.2 }
    );
  }, []);

  return (
    <div>
      {/* Hero Section */}
      <section ref={heroRef} style={{ minHeight: '92vh', display: 'flex', alignItems: 'center', justifyContent: 'center', textAlign: 'center', padding: '4rem 1.5rem' }}>
        <div style={{ maxWidth: '860px' }}>
          <div ref={badgeRef} style={{ display: 'inline-flex', alignItems: 'center', gap: '0.5rem', background: 'rgba(37,99,235,0.2)', border: '1px solid rgba(37,99,235,0.4)', borderRadius: '9999px', padding: '0.4rem 1.2rem', marginBottom: '1.5rem', fontSize: '0.875rem', color: '#60a5fa' }}>
            <GraduationCap size={16} /> Kenya's Premier Bursary Platform
          </div>

          <h1 ref={h1Ref} style={{ fontSize: 'clamp(2.5rem, 6vw, 5rem)', fontWeight: '800', lineHeight: 1.1, marginBottom: '1.5rem', background: 'linear-gradient(135deg, #ffffff 0%, #93c5fd 100%)', WebkitBackgroundClip: 'text', WebkitTextFillColor: 'transparent', backgroundClip: 'text' }}>
            Fund Your Future with<br />NIBS Bursary
          </h1>

          <p ref={subRef} style={{ fontSize: 'clamp(1rem, 2.5vw, 1.25rem)', color: '#94a3b8', marginBottom: '2.5rem', maxWidth: '600px', margin: '0 auto 2.5rem' }}>
            Access financial support for your education at Nairobi Institute of Business Studies. Apply online, track your application, and secure your academic future.
          </p>

          <div ref={btnRef} style={{ display: 'flex', gap: '1rem', justifyContent: 'center', flexWrap: 'wrap' }}>
            <Link to="/register" className="btn btn-primary" style={{ fontSize: '1rem', padding: '0.875rem 2rem', gap: '0.5rem', textDecoration: 'none' }}>
              Apply for Bursary <ArrowRight size={18} />
            </Link>
            <Link to="/login" className="btn btn-outline" style={{ fontSize: '1rem', padding: '0.875rem 2rem', textDecoration: 'none' }}>
              Check Application Status
            </Link>
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section style={{ padding: '4rem 1.5rem', background: 'rgba(0,0,0,0.3)' }}>
        <div className="container">
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '1.5rem' }}>
            {stats.map((s, i) => (
              <div key={i} className="glass-panel stat-card-item" style={{ padding: '2rem', textAlign: 'center' }}>
                <div style={{ fontSize: '2.25rem', fontWeight: '800', color: '#60a5fa', marginBottom: '0.5rem' }}>{s.value}</div>
                <div style={{ color: '#94a3b8', fontSize: '0.9rem' }}>{s.label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section style={{ padding: '5rem 1.5rem' }}>
        <div className="container">
          <div style={{ textAlign: 'center', marginBottom: '3rem' }}>
            <h2 style={{ fontSize: 'clamp(1.75rem, 4vw, 2.5rem)', fontWeight: '700' }}>Why Choose NIBS Bursary?</h2>
            <p style={{ color: '#94a3b8', marginTop: '0.75rem', maxWidth: '500px', margin: '0.75rem auto 0' }}>Simple, transparent, and student-first financial support designed for Kenyan students.</p>
          </div>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(260px, 1fr))', gap: '1.5rem' }}>
            {features.map((f, i) => (
              <div key={i} className="glass-panel feature-card" style={{ padding: '2rem' }}>
                <div style={{ color: '#60a5fa', marginBottom: '1rem' }}>{f.icon}</div>
                <h3 style={{ fontSize: '1.125rem', fontWeight: '600', marginBottom: '0.75rem' }}>{f.title}</h3>
                <p style={{ fontSize: '0.9rem', color: '#94a3b8' }}>{f.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section style={{ padding: '5rem 1.5rem' }}>
        <div className="container">
          <div className="glass-panel" style={{ padding: '3rem', textAlign: 'center', background: 'linear-gradient(135deg, rgba(37,99,235,0.2) 0%, rgba(16,185,129,0.1) 100%)' }}>
            <h2 style={{ fontSize: 'clamp(1.5rem, 3.5vw, 2.25rem)', marginBottom: '1rem' }}>Ready to Start Your Journey?</h2>
            <p style={{ color: '#94a3b8', marginBottom: '2rem' }}>Join thousands of Kenyan students who have secured their futures with NIBS Bursary support.</p>
            <Link to="/register" className="btn btn-primary" style={{ fontSize: '1rem', padding: '0.875rem 2rem', textDecoration: 'none' }}>
              Get Started Today
            </Link>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer style={{ borderTop: '1px solid rgba(255,255,255,0.1)', padding: '2rem 1.5rem', textAlign: 'center', color: '#64748b', fontSize: '0.875rem' }}>
        <div className="container">
          <p>© 2026 NIBS Bursary System — Nairobi Institute of Business Studies. All rights reserved.</p>
        </div>
      </footer>
    </div>
  );
}
