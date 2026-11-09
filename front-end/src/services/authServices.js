const API_BASE_URL = 'http://localhost:8000/api'

export const loginUser = async (email, password) =>{
    const response = await fetch(`${API_BASE_URL}/login`,{
        method : 'POST', 
        headers : {
            'Content-Type' : 'application/json'
        },
        credentials: 'include', 
        body: JSON.stringify({email, password}),
    });
    const result = await response.json();

    if (!response.ok || result.status !== 'success'){
        throw new Error (result.message || 'Login Failed, check your cridential ')
    }
    return result.data;
    
}


export const registerUser = async (name,email, password ) =>{
    const response = await fetch (`${API_BASE_URL}/register`,{
        method : 'POST',
        headers : {
            'Content-Type' : 'application/json'
        }, 
        body: JSON.stringify({name, email, password}),
    });
    const result = await response.json()

    if (!response.ok || result.status !== 'success'){
        throw new Error (result.message || 'Register Failed');
        
    }
    return result.data
}


export const getProfile = async ()=>{
    const response = await fetch(`${API_BASE_URL}/profile`, {
        method : 'GET', 
        credentials : 'include'
    });
    const result = await response.json();

    if(!response.ok || result.status !== 'succesfully'){
        throw new Error(result.message || 'Unauthorized');
    };
    return result.data.user
}