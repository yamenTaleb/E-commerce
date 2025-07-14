import React, { useState } from 'react'

const Login = () => {
    const [currentState,setCurrentState] = useState('Sign Up');
    const onSubmitHandler = async(event)=> {
        event.preventDefault();
    }

  return (

        <form onSubmit={onSubmitHandler} className='d-flex flex-column align-items-center w-90 custom-max-w-96 mx-auto mt-5 text-dark gap-3 '>
            <div className='d-inline-flex align-items-center mt-5 gap-2'>
                <p className='prata-regular fs-2'>{currentState}</p>
                <hr style={{height: '2px'}} className='bg-black border-0 w-8 '/>
            </div>
            {currentState==='Login' ?'':<input type="text" className='w-100 px-3 py-2 border border-dark' placeholder='Name' required/>}
            <input type="email" className='w-100 px-3 py-2 border border-dark' placeholder='email' required/>
            <input type="password" className='w-100 px-3 py-2 border border-dark' placeholder='password' required/>
            <div className='w-100 d-flex justify-content-between small mt--8px'>
                <p className='pointer'>Forgot your password?</p>
                {
                    currentState==='Login'
                    ?<p onClick={()=>setCurrentState('Sign Up')} className='pointer'>Creat account</p>
                    :<p onClick={()=>setCurrentState('Login')} className='pointer'>Login Here</p>
                }
            </div>
            <button className='bg-black text-white fw-light px-5 py-2 mt-4'>{currentState==='Login'? 'Sign In':'Sign Up'}</button>
        </form>

  )
}

export default Login
