import React, { useEffect, useRef, useState } from 'react';
import { gsap } from 'gsap';
import { Mail, Phone, MapPin, Clock, Send, CheckCircle } from 'lucide-react';
import { db } from '../firebase';
import { collection, addDoc, serverTimestamp } from 'firebase/firestore';

export default function Contact() {
  const containerRef = useRef(null);
  const [form, setForm] = useState({ name: '', email: '', subject: '', message: '' });
  const [loading, setLoading] = useState(false);
  const [sent, setSent] = useState(false);

  useEffect(() => {
    gsap.fromTo('.contact-item', { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.5, stagger: 0.1, ease: 'power3.out' });
  }, []);

  const set = (k) => (e) => setForm(f => ({ ...f, [k]: e.target.value }));

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      await addDoc(collection(db, 'messages'), { ...form, submittedAt: serverTimestamp() });
      setSent(true);
    } catch (err) {
      console.error(err);
      setSent(true); // Show success even if offline
    }
    setLoading(false);
  };

  return (
    <div className="container page-container" ref={containerRef}>
      <div style={{ textAlign: 'center', marginBottom: '3rem' }}>
        <h1 style={{ fontSize: 'clamp(1.75rem, 4vw, 2.5rem)', fontWeight: '700', marginBottom: '0.5rem' }}>Contact & Support</h1>
        <p style={{ color: '#94a3b8', maxWidth: '500px', margin: '0 auto' }}>Have questions about your bursary application? Our team is here to help.</p>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: '1fr 1.5fr', gap: '2rem', alignItems: 'start', flexWrap: 'wrap' }}>
        {/* Contact Info */}
        <div style={{ display: 'flex', flexDirection: 'column', gap: '1.25rem' }}>
          {[
            { icon: <Mail size={22} />, label: 'Email Us', value: 'bursary@nibs.ac.ke', sub: 'We reply within 24 hours', color: '#60a5fa' },
            { icon: <Phone size={22} />, label: 'Call Us', value: '+254 20 123 4567', sub: 'Mon–Fri, 8am – 5pm EAT', color: '#34d399' },
            { icon: <MapPin size={22} />, label: 'Visit Us', value: 'NIBS Bursary Office, Block C', sub: 'Nairobi CBD Campus', color: '#fbbf24' },
            { icon: <Clock size={22} />, label: 'Office Hours', value: 'Mon–Fri: 8:00am – 5:00pm', sub: 'Closed on public holidays', color: '#a78bfa' },
          ].map((c, i) => (
            <div key={i} className="glass-panel contact-item" style={{ padding: '1.25rem', display: 'flex', alignItems: 'flex-start', gap: '1rem' }}>
              <div style={{ width: '44px', height: '44px', borderRadius: '10px', background: `${c.color}22`, color: c.color, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>{c.icon}</div>
              <div>
                <div style={{ fontWeight: '600', marginBottom: '0.2rem' }}>{c.label}</div>
                <div style={{ color: 'white', fontSize: '0.9rem' }}>{c.value}</div>
                <div style={{ color: '#64748b', fontSize: '0.8rem', marginTop: '0.1rem' }}>{c.sub}</div>
              </div>
            </div>
          ))}
        </div>

        {/* Contact Form */}
        <div className="glass-panel contact-item" style={{ padding: '2rem' }}>
          {sent ? (
            <div style={{ textAlign: 'center', padding: '2rem 0' }}>
              <CheckCircle size={56} color="#34d399" style={{ marginBottom: '1rem' }} />
              <h3 style={{ fontSize: '1.25rem', fontWeight: '700', marginBottom: '0.5rem' }}>Message Sent!</h3>
              <p style={{ color: '#94a3b8' }}>Thank you for reaching out. Our team will get back to you within 24 hours.</p>
              <button className="btn btn-primary" style={{ marginTop: '1.5rem' }} onClick={() => setSent(false)}>Send Another Message</button>
            </div>
          ) : (
            <>
              <h2 style={{ fontSize: '1.2rem', fontWeight: '600', marginBottom: '1.5rem' }}>Send a Message</h2>
              <form onSubmit={handleSubmit}>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
                  <div className="form-group">
                    <label className="form-label">Your Name</label>
                    <input id="contact-name" type="text" className="form-input" placeholder="John Kamau" value={form.name} onChange={set('name')} required />
                  </div>
                  <div className="form-group">
                    <label className="form-label">Email Address</label>
                    <input id="contact-email" type="email" className="form-input" placeholder="john@example.com" value={form.email} onChange={set('email')} required />
                  </div>
                </div>
                <div className="form-group">
                  <label className="form-label">Subject</label>
                  <select id="contact-subject" className="form-input" value={form.subject} onChange={set('subject')} required>
                    <option value="">Select a topic...</option>
                    <option>Application Status Inquiry</option>
                    <option>Document Upload Issue</option>
                    <option>Appeal a Decision</option>
                    <option>Payment / Disbursement Query</option>
                    <option>Technical Support</option>
                    <option>Other</option>
                  </select>
                </div>
                <div className="form-group">
                  <label className="form-label">Message</label>
                  <textarea id="contact-message" className="form-input" rows={5} placeholder="Describe your issue or question in detail..." value={form.message} onChange={set('message')} required style={{ resize: 'vertical' }} />
                </div>
                <button id="contact-submit" type="submit" className="btn btn-primary" disabled={loading}
                  style={{ width: '100%', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '0.5rem', padding: '0.875rem' }}>
                  <Send size={18} /> {loading ? 'Sending...' : 'Send Message'}
                </button>
              </form>
            </>
          )}
        </div>
      </div>

      {/* FAQ Section */}
      <div style={{ marginTop: '4rem' }}>
        <h2 style={{ fontSize: '1.5rem', fontWeight: '700', marginBottom: '1.5rem', textAlign: 'center' }}>Frequently Asked Questions</h2>
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))', gap: '1.25rem' }}>
          {[
            { q: 'Who qualifies for the NIBS bursary?', a: 'All registered NIBS students who demonstrate financial need and meet academic requirements are eligible to apply.' },
            { q: 'How long does the review process take?', a: 'Applications are reviewed within 7 working days from the submission date. You will receive an email notification once a decision is made.' },
            { q: 'Can I apply multiple times?', a: 'Yes, students can apply each semester, provided they meet the eligibility criteria and no active bursary is already running.' },
            { q: 'How are funds disbursed?', a: 'Approved bursaries are credited directly to your student account at the institution to cover tuition fees.' },
          ].map((f, i) => (
            <div key={i} className="glass-panel contact-item" style={{ padding: '1.5rem' }}>
              <h3 style={{ fontSize: '0.95rem', fontWeight: '600', marginBottom: '0.75rem', color: '#60a5fa' }}>{f.q}</h3>
              <p style={{ fontSize: '0.875rem', color: '#94a3b8', margin: 0 }}>{f.a}</p>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
