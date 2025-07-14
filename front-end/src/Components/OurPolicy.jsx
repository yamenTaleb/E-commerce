import React from 'react'
import { assets } from '../assets/assets'

const OurPolicy = () => {
  return (

    <div className='d-flex flex-column flex-sm-row custom-gap-responsive justify-content-around py-5 small text-secondary fs-6 fs-md-5 text-center'>
        <div style={{fontSize:'12px'}}>
            <img src={assets.exchange_icon} className='w-12 m-auto mb-3'  alt="" />
            <p className='fw-semibold text-black'>Easy Exchange Policy</p>
            <p className='text-muted'>We offer hassle free exchange policy</p>
        </div>
        <div style={{fontSize:'12px'}}>
            <img src={assets.quality_icon} className='w-12 m-auto mb-3'  alt="" />
            <p className='fw-semibold text-black'>7 Days Return Policy</p>
            <p className='text-muted'>We provide 7 days free return policy</p>
        </div>
        <div style={{fontSize:'12px'}}>
            <img src={assets.support_img} className='w-12 m-auto mb-3'  alt="" />
            <p className='fw-semibold text-black'>Best customer support</p>
            <p className='text-muted'>we provide 24/7 customer suppor</p>
        </div>


    </div>
  )
}

export default OurPolicy

