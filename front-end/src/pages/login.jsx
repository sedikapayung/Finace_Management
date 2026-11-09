import { useState } from "react";
import { Link } from "react-router-dom";
import '../styles/login.css'
import { useAuth } from "../hooks/useAuth";

export default function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState(''); // Perbaikan nama fungsi 
    
    const {handleLogin, loading, errorMsg, setErrorMsg}= useAuth();
    
    const  onSubmit = (e) => {
        e.preventDefault();
        handleLogin(email, password)
    }

    
    return (
        <div className="container-fluid min-vh-100 d-flex p-0 bg-light">
            <div className="row g-0 w-100 flex-grow-1">
                {/* Sisi Kiri: Banner Info */}
                <div className="col-lg-8 authBanner text-white d-none d-lg-flex flex-column justify-content-center p-5 position-relative overflow-hidden">
                    <div className="position-relative z-1 max-w-md mx-auto">
                        <span className="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold mb-3">
                            ✨ Smart Financial Platform
                        </span>
                        <h1 className="display-4 fw-bold mb-3">Financial Freedom</h1>
                        <p className="lead opacity-75">
                            Track your spending, reach your financial goals, and achieve financial freedom with us.
                        </p>
                    </div>
                </div>

                {/* Sisi Kanan: Form Login */}
                <div className="col-lg-4 d-flex  flex-column justify-content-center p-5 ">

                    <div className="text-center mb-4">
                        <h2 className="fw-bold text-dark mb-1">Finance Management</h2>
                        <p className="text-muted small">Please log in to your account</p>
                    </div>

                    {errorMsg && (
                        <div className="alert alert-danger alert-dismissible fade show" role="alert">
                            <i className="bi bi-exclamation-triangle-fill me-2"></i>
                            {errorMsg}
                        </div>
                    )}

                    <form onSubmit={onSubmit}>
                        <div className="mb-3">
                            <label htmlFor="email" className="form-label fw-medium text-secondary">
                                Email Address
                            </label>
                            <input
                                type="email"
                                id="email"
                                className="form-control form-control-lg fs-6"
                                placeholder="name@example.com"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                
                            />
                        </div>

                        <div className="mb-4">
                            <label htmlFor="password" className="form-label fw-medium text-secondary">
                                Password
                            </label>
                            <input
                                type="password"
                                id="password"
                                className="form-control form-control-lg fs-6"
                                placeholder="Enter your password"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                            />
                        </div>

                        <button
                            type="submit"
                            className="btn btn-primary btn-lg w-100 fw-semibold mb-3 shadow-sm"
                            disabled={loading}
                        >
                            {loading ? (
                                <>
                                    <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    Memproses...
                                </>
                            ) : 'Masuk'}
                        </button>
                    </form>

                    <div className="text-center mt-3">
                        <p className="text-muted mb-0">
                            Belum punya akun?{' '}
                            <Link to="/register" className="text-primary text-decoration-none fw-semibold">
                                Daftar di sini
                            </Link>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    );
}