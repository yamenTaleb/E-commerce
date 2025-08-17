import React from 'react'
import Title from '../Components/Title'
import { assets } from '../assets/assets'
import NewsletterBox from '../Components/NewsletterBox'

const About = () => {
  return (
    <div>
        <div className='fs-3 text-center pt-5 border-top'>
            <Title text1={'ABOUT'} text2={'US'}/>
        </div>

        <div className='my-5 d-flex flex-column flex-md-row gap-5'>
            <img className='w-100 md-max-w-450' src={assets.about_img} alt="" />
            <div className='d-flex flex-column justify-content-center gap-5 text-secondary md-w-50'>
                <p>Forever was born out of a passion for innovation and a desire to revolutionize the way people shop online. Our journey began with a simple idea: to provide a platform where customers can easily discover, explore, and purchase a wide range of products from the comfort of their homes.</p>
                <p>Since our inception, we've worked tirelessly to curate a diverse selection of high-quality products that cater to every taste and preference. From fashion and beauty to electronics and home essentials, we offer an extensive collection sourced from trusted brands and suppliers.</p>
                <b className='text-dark'>Our Mission</b>
                <p>Our mission at Forever is to empower customers with choice, convenience, and confidence. We're dedicated to providing a seamless shopping experience that exceeds expectations, from browsing and ordering to delivery and beyond.</p>
            </div>
        </div>

        <div className='fs-4 py-3'>
            <Title text1={'WHY'} text2={'CHOOSE US'}/>
        </div>

        <div className='d-flex flex-column flex-md-row small mb-5'>
            <div className='border px-10 px-md-16 py-8 py-sm-20 d-flex flex-column gap-4'>
                <b>Quality Assurance:</b>
                <p className='text-secondary'>We meticulously select and vet each product to ensure it meets our stringent quality standards.</p>
            </div>
            <div className='border px-10 px-md-16 py-8 py-sm-20 d-flex flex-column gap-4'>
                <b>Convenience:</b>
                <p className='text-secondary'>With our user-friendly interface and hassle-free ordering process, shopping has never been easier.</p>
            </div>
            <div className='border px-10 px-md-16 py-8 py-sm-20 d-flex flex-column gap-4'>
                <b>Exceptional Customer Service:</b>
                <p className='text-secondary'>Our team of dedicated professionals is here to assist you the way, ensuring your satisfaction is our top priority.</p>
            </div>
        </div>

        <NewsletterBox/>
    </div>
  )
}

export default About

