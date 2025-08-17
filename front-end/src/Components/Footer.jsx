import React from 'react'
import { assets } from '../assets/assets'

const Footer = () => {
  return (
    <div>
        <div className='d-flex flex-column flex-sm-row custom-grid gap-5 mt-40 small'>
            <div>
                <img src={assets.logo} className='mb-3 w-32' alt="" />
                <p className='w-100 md-w-66 text-secondary small'>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam illum rerum exercitationem! Dolorem, atque magni illo voluptate distinctio reprehenderit enim laudantium culpa in illum odit vitae ipsum voluptas, recusandae sint!
                </p>
            </div>
            <div>
                <p className='fs-6 fw-semibold mb-3'>COMPANY</p>
                <ul className='d-flex flex-column gap-1 text-secondary small p-0'>
                    <li>Home</li>
                    <li>About</li>
                    <li>Delivery</li>
                    <li>Privacy policy</li>
                </ul>
            </div>

            <div>
                <p className='fs-6 fw-semibold mb-3'>GET IN TOUCH</p>
                <ul className='d-flex flex-column gap-1 text-secondary small p-0'>
                    <li>+1-000-000-0000</li>
                    <li>greatstackdev@gmail.com Instagram</li>
                </ul>
            </div>

        </div>

        <div>
            <hr />
            <p className='py-3 small text-center'>Copyright 2024@ greatstack.dev - All Right Reserved.</p>
        </div>

    </div>
  )
}

export default Footer

