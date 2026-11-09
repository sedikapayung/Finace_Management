import { Outlet } from "react-router-dom";
import Sidebar from "../components/sidebar";

export default function MainLayout() {
    return (
        <div className="d-flex">
            {/* Sidebar yang akan selalu tampil */}
            <Sidebar />

            {/* Area Konten Utama yang berubah-ubah sesuai halaman */}
            <div className="flex-grow-1 bg-light p-4" style={{ minHeight: "100vh" }}>
                <Outlet />
            </div>
        </div>
    );
}