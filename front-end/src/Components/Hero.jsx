import React from 'react'
import {assets} from '../assets/assets'
const Hero = () => {
  return (
    <div className='d-flex flex-column flex-sm-row border border-secondary'>
        {/* Hero Left Side */}
        <div className='w-100 w-sm-50 d-flex align-items-center justify-content-center py-5 py-sm-0'>
            <div className=''>
                <div className="d-flex align-items-center gap-2">
                    <p className='w-8 w-md-11 h-2px bg-414141'></p>
                    <p className='fw-semibold fs-6 fs-md-5'>OUR BESTSELLERS</p>
                </div>
                <h1 className='prata-regular fs-2 fs-lg-display-3 py-sm-3 lh-base'>Latest Arrivals</h1>
                <div className='d-flex align-items-center gap-2'>
                    <p className='fw-semibold fs-6 fs-md-5'>SHOP NOW</p>
                    <p className='w-8 w-md-11 h-2px bg-414141'></p>
                </div>
            </div>

        </div>
        {/* Hero Right Side */}
        <img className='w-100 w-sm-50' src={assets.hero_img} alt="" />


    </div>
  )
}

export default Hero

