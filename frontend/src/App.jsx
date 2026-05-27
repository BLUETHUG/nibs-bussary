import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';

// Pages
import Home from './pages/Home';
import Login from './pages/Login';
import Register from './pages/Register';
import Contact from './pages/Contact';

// Student Pages
import StudentDashboard from './pages/StudentDashboard';
import Apply from './pages/Apply';
import Status from './pages/Status';
import Profile from './pages/Profile';

// Admin Pages
import AdminDashboard from './pages/AdminDashboard';
import ManageApplications from './pages/ManageApplications';
import ManageStudents from './pages/ManageStudents';

function App() {
  return (
    <Router>
      <div className="app-background"></div>
      <Navbar />
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/contact" element={<Contact />} />
        
        {/* Student Routes */}
        <Route path="/student/dashboard" element={<StudentDashboard />} />
        <Route path="/student/apply" element={<Apply />} />
        <Route path="/student/status" element={<Status />} />
        <Route path="/student/profile" element={<Profile />} />
        
        {/* Admin Routes */}
        <Route path="/admin/dashboard" element={<AdminDashboard />} />
        <Route path="/admin/applications" element={<ManageApplications />} />
        <Route path="/admin/students" element={<ManageStudents />} />
      </Routes>
    </Router>
  );
}

export default App;
