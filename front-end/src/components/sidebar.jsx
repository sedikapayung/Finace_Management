import { Link } from "react-router-dom";

export default function Sidebar() {
    return (
        <div className="d-flex flex-column flex-shrink-0 p-3 bg-white border-end" style={{ width: "280px", minHeight: "100vh" }}>
            <a href="/" className="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <span className="fs-4 fw-bold">Finance App</span>
            </a>
            <hr />
            <ul className="nav nav-pills flex-column mb-auto">
                <li className="nav-item mb-1">
                    <Link to="/dashboard" className="nav-link text-dark">
                        <i className="bi bi-house-door me-2"></i> Dashboard
                    </Link>
                </li>
                <li className="nav-item mb-1">
                    <Link to="/transactions" className="nav-link text-dark">
                        <i className="bi bi-wallet2 me-2"></i> Transaksi
                    </Link>
                </li>
                <li className="nav-item mb-1">
                    <Link to="/settings" className="nav-link text-dark">
                        <i className="bi bi-gear me-2"></i> Pengaturan
                    </Link>
                </li>
            </ul>
        </div>
    );
}