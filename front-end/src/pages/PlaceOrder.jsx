import React, { useContext, useState } from 'react'
import Title from '../Components/Title'
import CartTotal from '../context/CartTotal'
import { assets } from '../assets/assets'
import { ShopContext } from '../context/ShopContext'

const PlaceOrder = () => {

    const [method,setMethod] = useState('');
    const {navigate} = useContext(ShopContext)

  return (
    <div className='d-flex flex-column flex-sm-row justify-content-between gap-4 pt-4 pt-sm-5 min-h-80vh border-top'>
        {/* ----- Left Side ----- */}
        <div className='d-flex flex-column gap-4 w-75 max-w-sm-400'>
            <div className='fs-5 fs-sm-4 my-3'>
                <Title text1={'DELIVERY'} text2={'INFORMATION'}/>
            </div>
            <div className='d-flex gap-2'>
                <input className='border border-secondary rounded py-1 px-3 w-100' type="text" placeholder='First name'/>
                <input className='border border-secondary rounded py-1 px-3 w-100' type="text" placeholder='Last name'/>
            </div>
            <input className='border border-secondary rounded py-1 px-3 w-100' type="email" placeholder='Email address'/>
            <input className='border border-secondary rounded py-1 px-3 w-100' type="text" placeholder='Street'/>
            <div className='d-flex gap-2'>
                <input className='border border-secondary rounded py-1 px-3 w-100' type="text" placeholder='City'/>
                <input className='border border-secondary rounded py-1 px-3 w-100' type="text" placeholder='State'/>
            </div>
            <div className='d-flex gap-2'>
                <input className='border border-secondary rounded py-1 px-3 w-100' type="number" placeholder='Zipcode'/>
                <input className='border border-secondary rounded py-1 px-3 w-100' type="text" placeholder='Country'/>
            </div>
            <input className='border border-secondary rounded py-1 px-3 w-100' type="number" placeholder='Phone'/>
        </div>

        {/* ------ Right Side -------- */}

        <div className='mt-5'>
            <div className='mt-5 min-w-80vh ms-5'>
                <CartTotal/>
            </div>

            <div className='mt-5 ms-5'>
                <Title text1={'PAYMENT'} text2={'METHOD'}/>
                {/* ------ Payment Method */}
                <div className='d-flex gap-2 flex-column flex-lg-row'>
                    <div onClick={()=>setMethod('stripe')} className='d-flex align-items-center gap-2 border p-2 px-3 pointer'>
                        <p className={`min-w-3-5 h-3-5 border my-auto rounded-circle ${method === 'stripe' ? 'bg-success' : ''}`}></p>
                        <img className='mx-1' src={assets.stripe_logo} alt="" />
                    </div>
                </div>

                <div className='w-100 text-center mt-5'>
                    <button onClick={()=>navigate('/orders')} className='bg-black border-0 text-white px-5 py-2 small '>PLACE ORDER</button>
                </div>
            </div>
        </div>
    </div>
  )
}

export default PlaceOrder

