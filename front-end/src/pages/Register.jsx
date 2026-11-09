import { useState } from "react";
import { Link } from "react-router-dom";
import { useAuth } from "../hooks/useAuth";

export default function Register() {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('')

    const { handleRegister, loading, errorMsg } = useAuth();


    const submited = (e) => {
        e.preventDefault();
        handleRegister(name, email, password);
    }


    return (
        <div className="container-fluid min-vh-100 d-flex p-0 bg-light">
            <div className="row g-0 w-100 flex-grow-1">
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

                <div className="col-lg-4 d-flex  flex-column justify-content-center p-5 ">
                    <div className="text-center mb4">
                        <p>Regist Your Account</p>
                    </div>
                    {errorMsg && (
                        <div className="alert alert-danger alert-dismissible fade show" role="alert">
                            <i className="bi bi-exclamation-triangle-fill me-2"></i>
                            {errorMsg}
                        </div>
                    )}

                    <form onSubmit={submited}>
                        <div className="mb-3">
                            <label htmlFor="name" className="form-label fw-medium text-secondary">
                                Name
                            </label>
                            <input
                                type="text"
                                id="name"
                                className="form-control form-control-lg fs-6"
                                placeholder="Name"
                                value={name}
                                onChange={(e) => setName(e.target.value)}

                            />
                        </div>

                        <div className="mb-4">
                            <label htmlFor="Email" className="form-label fw-medium text-secondary">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                className="form-control form-control-lg fs-6"
                                placeholder="example.com"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                            />
                        </div>

                        <div className="mb-4">
                            <label htmlFor="Password" className="form-label fw-medium text-secondary">
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
                        <div className="mb-4">
                            <label htmlFor="confirmPassword" className="form-label fw-medium text-secondary">
                                Confirm Password
                            </label>
                            <input
                                type="text"
                                id="confirmPassword"
                                className="form-control form-control-lg fs-6"
                                placeholder="Confirm Password"
                                value={confirmPassword}
                                onChange={(e) => setConfirmPassword(e.target.value)}
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
                                    Processing...
                                </>
                            ) : 'Masuk'}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    )

}