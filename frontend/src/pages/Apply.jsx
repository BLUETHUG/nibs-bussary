import React, { useEffect, useRef, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { gsap } from 'gsap';
import { CheckCircle, ChevronRight, ChevronLeft, Upload, User, BookOpen, DollarSign } from 'lucide-react';
import { auth, db } from '../firebase';
import { collection, addDoc, serverTimestamp } from 'firebase/firestore';

const steps = ['Personal Info', 'Academic Details', 'Financial Need', 'Documents', 'Review'];

export default function Apply() {
  const [step, setStep] = useState(0);
  const [submitted, setSubmitted] = useState(false);
  const [loading, setLoading] = useState(false);
  const formRef = useRef(null);
  const navigate = useNavigate();

  const [form, setForm] = useState({
    fullName: '', dob: '', gender: '', nationalId: '', county: '',
    admNo: '', course: '', year: '', institution: 'Nairobi Institute of Business Studies',
    guardian: '', guardianPhone: '', guardianOccupation: '', income: '', siblings: '',
    reason: '', amount: '',
    transcript: null, idCopy: null, feeStatement: null,
  });

  const set = (k) => (e) => setForm(f => ({ ...f, [k]: e.target.value }));

  useEffect(() => {
    gsap.fromTo(formRef.current, { opacity: 0, x: 30 }, { opacity: 1, x: 0, duration: 0.4, ease: 'power2.out' });
  }, [step]);

  const next = () => { if (step < steps.length - 1) setStep(s => s + 1); };
  const back = () => { if (step > 0) setStep(s => s - 1); };

  const handleSubmit = async () => {
    setLoading(true);
    try {
      await addDoc(collection(db, 'applications'), {
        ...form, uid: auth.currentUser?.uid || 'guest',
        status: 'pending', submittedAt: serverTimestamp(),
      });
      setSubmitted(true);
    } catch (e) {
      console.error(e);
    }
    setLoading(false);
  };

  if (submitted) return (
    <div className="container page-container" style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: '70vh' }}>
      <div className="glass-panel" style={{ padding: '3rem', textAlign: 'center', maxWidth: '480px' }}>
        <CheckCircle size={64} color="#34d399" style={{ marginBottom: '1.5rem' }} />
        <h2 style={{ fontSize: '1.5rem', fontWeight: '700', marginBottom: '0.75rem' }}>Application Submitted!</h2>
        <p style={{ color: '#94a3b8', marginBottom: '2rem' }}>Your bursary application has been received. We'll review it within 7 working days and notify you via email.</p>
        <button className="btn btn-primary" onClick={() => navigate('/student/dashboard')} style={{ width: '100%' }}>Go to Dashboard</button>
      </div>
    </div>
  );

  const Input = ({ id, label, type = 'text', val, onChange, placeholder }) => (
    <div className="form-group">
      <label className="form-label">{label}</label>
      <input id={id} type={type} className="form-input" placeholder={placeholder} value={val} onChange={onChange} />
    </div>
  );

  const Select = ({ id, label, val, onChange, options }) => (
    <div className="form-group">
      <label className="form-label">{label}</label>
      <select id={id} className="form-input" value={val} onChange={onChange}>
        <option value="">Select...</option>
        {options.map(o => <option key={o}>{o}</option>)}
      </select>
    </div>
  );

  const renderStep = () => {
    switch (step) {
      case 0: return (
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
          <div style={{ gridColumn: '1/-1' }}><Input id="ap-name" label="Full Name (as per ID)" placeholder="John Kamau" val={form.fullName} onChange={set('fullName')} /></div>
          <Input id="ap-dob" label="Date of Birth" type="date" val={form.dob} onChange={set('dob')} />
          <Select id="ap-gender" label="Gender" val={form.gender} onChange={set('gender')} options={['Male', 'Female', 'Prefer not to say']} />
          <Input id="ap-id" label="National ID / Birth Certificate No." placeholder="12345678" val={form.nationalId} onChange={set('nationalId')} />
          <Select id="ap-county" label="County of Origin" val={form.county} onChange={set('county')} options={['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Thika', 'Other']} />
        </div>
      );
      case 1: return (
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
          <Input id="ap-adm" label="Admission Number" placeholder="NIBS/2026/001" val={form.admNo} onChange={set('admNo')} />
          <Select id="ap-year" label="Year of Study" val={form.year} onChange={set('year')} options={['Year 1', 'Year 2', 'Year 3', 'Year 4']} />
          <div style={{ gridColumn: '1/-1' }}>
            <Select id="ap-course" label="Course / Programme" val={form.course} onChange={set('course')} options={['Business Administration', 'ICT', 'Accounting & Finance', 'Journalism & Media', 'Hospitality Management', 'Education']} />
          </div>
          <div style={{ gridColumn: '1/-1' }}><Input id="ap-inst" label="Institution" val={form.institution} onChange={set('institution')} /></div>
        </div>
      );
      case 2: return (
        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
          <Input id="ap-guardian" label="Guardian / Parent Name" placeholder="Jane Kamau" val={form.guardian} onChange={set('guardian')} />
          <Input id="ap-gphone" label="Guardian Phone" placeholder="+254 700 000 000" val={form.guardianPhone} onChange={set('guardianPhone')} />
          <Input id="ap-gocc" label="Guardian Occupation" placeholder="Farmer / Teacher / etc." val={form.guardianOccupation} onChange={set('guardianOccupation')} />
          <Select id="ap-income" label="Monthly Household Income" val={form.income} onChange={set('income')} options={['Below KSh 10,000', 'KSh 10,000 – 30,000', 'KSh 30,000 – 50,000', 'Above KSh 50,000']} />
          <Select id="ap-sib" label="No. of Siblings in School" val={form.siblings} onChange={set('siblings')} options={['0', '1', '2', '3', '4+']} />
          <Select id="ap-amount" label="Amount Requested" val={form.amount} onChange={set('amount')} options={['KSh 10,000', 'KSh 20,000', 'KSh 30,000', 'KSh 45,000', 'Full Fees']} />
          <div style={{ gridColumn: '1/-1' }} className="form-group">
            <label className="form-label">Reason for Applying (describe your financial situation)</label>
            <textarea id="ap-reason" className="form-input" rows={4} placeholder="Please explain your financial need in detail..." value={form.reason} onChange={set('reason')} style={{ resize: 'vertical' }} />
          </div>
        </div>
      );
      case 3: return (
        <div style={{ display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
          {[
            { label: 'Academic Transcript / Report Card', id: 'ap-transcript' },
            { label: 'Copy of National ID / Birth Certificate', id: 'ap-idcopy' },
            { label: 'Fee Statement from Institution', id: 'ap-feestatement' },
          ].map(d => (
            <div key={d.id} style={{ border: '2px dashed rgba(255,255,255,0.2)', borderRadius: '12px', padding: '1.5rem', textAlign: 'center' }}>
              <Upload size={28} color="#60a5fa" style={{ marginBottom: '0.5rem' }} />
              <p style={{ color: 'white', fontWeight: '500', marginBottom: '0.25rem' }}>{d.label}</p>
              <p style={{ color: '#64748b', fontSize: '0.8rem', marginBottom: '1rem' }}>PDF, JPG, PNG — Max 5MB</p>
              <label className="btn btn-outline" style={{ cursor: 'pointer', fontSize: '0.875rem' }}>
                Choose File <input id={d.id} type="file" accept=".pdf,.jpg,.png" style={{ display: 'none' }} />
              </label>
            </div>
          ))}
        </div>
      );
      case 4: return (
        <div>
          <h3 style={{ marginBottom: '1.5rem', color: '#94a3b8' }}>Please review your application before submitting:</h3>
          <div style={{ display: 'grid', gap: '0.75rem' }}>
            {[
              ['Full Name', form.fullName], ['Date of Birth', form.dob], ['National ID', form.nationalId],
              ['County', form.county], ['Admission No.', form.admNo], ['Course', form.course],
              ['Year', form.year], ['Guardian', form.guardian], ['Income Level', form.income],
              ['Amount Requested', form.amount],
            ].map(([k, v]) => (
              <div key={k} style={{ display: 'flex', justifyContent: 'space-between', padding: '0.75rem', background: 'rgba(0,0,0,0.2)', borderRadius: '8px' }}>
                <span style={{ color: '#94a3b8', fontSize: '0.875rem' }}>{k}</span>
                <span style={{ fontWeight: '500', fontSize: '0.875rem' }}>{v || '—'}</span>
              </div>
            ))}
          </div>
        </div>
      );
      default: return null;
    }
  };

  return (
    <div className="container page-container">
      <h1 style={{ fontSize: '1.75rem', fontWeight: '700', marginBottom: '0.5rem' }}>Bursary Application</h1>
      <p style={{ color: '#94a3b8', marginBottom: '2rem' }}>Complete all steps to submit your application.</p>

      {/* Stepper */}
      <div style={{ display: 'flex', alignItems: 'center', marginBottom: '2.5rem', gap: '0' }}>
        {steps.map((s, i) => (
          <React.Fragment key={i}>
            <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', gap: '0.5rem' }}>
              <div style={{
                width: '36px', height: '36px', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center',
                fontWeight: '700', fontSize: '0.875rem',
                background: i < step ? '#34d399' : i === step ? 'var(--primary)' : 'rgba(255,255,255,0.1)',
                color: i <= step ? 'white' : '#64748b', flexShrink: 0,
              }}>{i < step ? '✓' : i + 1}</div>
              <span style={{ fontSize: '0.7rem', color: i === step ? 'white' : '#64748b', whiteSpace: 'nowrap' }}>{s}</span>
            </div>
            {i < steps.length - 1 && <div style={{ flex: 1, height: '2px', background: i < step ? '#34d399' : 'rgba(255,255,255,0.1)', margin: '0 0.25rem', marginBottom: '1.5rem' }} />}
          </React.Fragment>
        ))}
      </div>

      <div className="glass-panel" style={{ padding: '2rem' }}>
        <div ref={formRef}>{renderStep()}</div>
        <div style={{ display: 'flex', justifyContent: 'space-between', marginTop: '2rem', paddingTop: '1.5rem', borderTop: '1px solid rgba(255,255,255,0.1)' }}>
          <button id="apply-back" className="btn btn-outline" onClick={back} disabled={step === 0} style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
            <ChevronLeft size={18} /> Back
          </button>
          {step < steps.length - 1 ? (
            <button id="apply-next" className="btn btn-primary" onClick={next} style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
              Next <ChevronRight size={18} />
            </button>
          ) : (
            <button id="apply-submit" className="btn btn-primary" onClick={handleSubmit} disabled={loading} style={{ background: '#10b981' }}>
              {loading ? 'Submitting...' : '✓ Submit Application'}
            </button>
          )}
        </div>
      </div>
    </div>
  );
}
