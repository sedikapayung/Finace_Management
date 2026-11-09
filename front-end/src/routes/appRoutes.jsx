import { Routes, Route } from "react-router-dom";
import Login from "../pages/login";
import Register from "../pages/Register"
import MainLayout from "../pages/mainlayout";
import Dasboard from "../pages/dasboard"

export default function AppRoutes() {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />

      <Route element={<MainLayout/>}>
          <Route path="/dasboard" element={<Dasboard/>}/>

      </Route>
      
    </Routes>
  );
}