import { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { getProfile } from "../services/authServices";

export default  function Dasboard(){
    const[user,setUser] = useState('');
    const[loading, setLoading] = useState('');
    const navigate = useNavigate();

    useEffect(()=>{
        getProfile().then(userData => {
            setUser(userData);
            setLoading(false);
        })
        .catch(()=> {
            navigate('/login');
        })
    },[navigate])
    if(loading){
        return <div style={{ padding: '20px' }}>Memeriksa sesi keamanan...</div>;
    }
    return (
        <div style={{ padding: '20px' }}>
            <h1>Dashboard</h1>
            <p>Mantap! Selamat datang, <strong>{user?.email || 'User'}</strong></p>
        </div>
    )
}