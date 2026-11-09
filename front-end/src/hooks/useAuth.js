import { useState } from "react";
import { Await, useNavigate } from "react-router";
import { loginUser, registerUser} from "../services/authServices";

export const useAuth = () => {
    const [loading, setLoading] = useState(false);
    const [errorMsg, setErrorMsg] = useState('');
    const navigate = useNavigate();

    const handleLogin = async (email, password) => {
        setLoading(true);
        setErrorMsg('');
        try {
            const data = await loginUser(email, password);
            navigate('/dasboard');
            return true;
        } catch (error) {
            setErrorMsg(error.message || 'Terjadi kesalahan koneksi ke server');
            return false;
        } finally {
            setLoading(false);
        }
    };

    const handleRegister = async (name, email, password)=>{
        setLoading(true);
        setErrorMsg('');

        try {
            const data = await registerUser(name, email, password);
            navigate('/login')
        } catch (error) {
            setErrorMsg(error.message || 'Terjadi Kesalahan')
            return false
        }finally{
            setLoading(false)
        }
        
    }

    return {
        handleLogin,
        handleRegister,
        loading,
        errorMsg,
        setErrorMsg
    }
}
