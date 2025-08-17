import React from 'react'
import Title from '../Components/Title'
import { assets } from '../assets/assets'
import NewsletterBox from '../Components/NewsletterBox'

const Contact = () => {
  return (
    <div>
        <div className='text-center fs-3 pt-5 border-top'>
            <Title text1={'CONTACT'} text2={'US'}/>
        </div>

        <div className='my-5 d-flex flex-column justify-content-center flex-md-row gap-5 mb-5'>
            <img className='w-100 max-w-md-400' src={assets.contact_img} alt="" />
            <div className='d-flex flex-column justify-content-center align-items-start gap-4'>
                <p className='font-semibold fs-4 text-dark'>Our Store</p>
                <p className='text-secondary'>54709 Willms Station <br/> Suite 350, Washington, USA</p>
                <p className='text-secondary'>Tel: (415) 555-0132 <br/> Email: admin@forever.com</p>
                <p className='font-semibold fs-4 text-dark'>Careers at Forever</p>
                <p className='text-secondary'>Learn more about our teams and job openings.</p>
                <button className='border border-black px-4 py-2 hover-bg-black hover-text-white transition-all'>Explore Jobs</button>
            </div>
        </div>
        <NewsletterBox/>
    </div>
  )
}

export default Contact

