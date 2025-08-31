import React, { useState, useContext } from 'react';
import { ShopContext } from '../context/ShopContext';

const Login = () => {
    const [currentState, setCurrentState] = useState('Sign Up');
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        password: '',
        phone: '',
        address: '',
        password_confirmation: '', // لـ Sign Up
    });

    const { login, register } = useContext(ShopContext);

    const onChangeHandler = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setFormData(prevData => ({ ...prevData, [name]: value }));
    };

    const onSubmitHandler = async (event) => {
        event.preventDefault();
        if (currentState === 'Login') {
            await login(formData.email, formData.password);
        } else { // Sign Up
            await register(
                formData.name,
                formData.email,
                formData.password,
                formData.password_confirmation,
                formData.phone,
                formData.address
            );
        }
    };


  return (

  <form onSubmit={onSubmitHandler} className='d-flex flex-column align-items-center w-90 custom-max-w-96 mx-auto mt-5 text-dark gap-3 '>
    <div className='d-inline-flex align-items-center mt-5 gap-2'>
        <p className='prata-regular fs-2'>{currentState}</p>
        <hr style={{height: '2px'}} className='bg-black border-0 w-8 '/>
    </div>
    {currentState==='Login' ? '' :
        <input
            type="text"
            className='w-100 px-3 py-2 border border-dark'
            placeholder='Name'
            required
            name='name'
            onChange={onChangeHandler}
            value={formData.name}
        />
    }
    <input
        type="email"
        className='w-100 px-3 py-2 border border-dark'
        placeholder='email'
        required
        name='email'
        onChange={onChangeHandler}
        value={formData.email}
    />
    <input
        type="password"
        className='w-100 px-3 py-2 border border-dark'
        placeholder='password'
        required
        name='password'
        onChange={onChangeHandler}
        value={formData.password}
    />
    {currentState==='Login' ? '' :
        <input
            type="password"
            className='w-100 px-3 py-2 border border-dark'
            placeholder='Confirm Password'
            required
            name='password_confirmation'
            onChange={onChangeHandler}
            value={formData.password_confirmation}
        />
    }
    {currentState==='Login' ? '' :
        <input
            type="text"
            className='w-100 px-3 py-2 border border-dark'
            placeholder='Phone'
            required
            name='phone'
            onChange={onChangeHandler}
            value={formData.phone}
        />
    }
    {currentState==='Login' ? '' :
        <input
            type="text"
            className='w-100 px-3 py-2 border border-dark'
            placeholder='Address'
            required
            name='address'
            onChange={onChangeHandler}
            value={formData.address}
        />
    }
    <div className='w-100 d-flex justify-content-between small mt--8px'>
        <p className='pointer'>Forgot your password?</p>
        {
            currentState==='Login'
            ?<p onClick={()=>setCurrentState('Sign Up')} className='pointer'>Create account</p>
            :<p onClick={()=>setCurrentState('Login')} className='pointer'>Login Here</p>
        }
    </div>
    <button className='btn bg-black text-white fw-light px-5 py-2 mt-4 button'>{currentState==='Login'? 'Sign In':'Sign Up'}</button>
</form>


  )
}

export default Login
