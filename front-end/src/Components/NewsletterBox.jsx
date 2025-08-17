import React from 'react'

const NewsletterBox = () => {
    const onSubmitHandler = (event) => {
        event.preventDefault();
    }

  return (
    <div className="row">
        <div className='text-center mt-30'>
        <p className='fs-4 fw-medium text-dark'>Subscribe now & get 20% off</p>
        <p style={{fontSize:'12px'}} className='text-muted mt-3 mb-3'>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Labore quo blanditiis assumenda rem, quas accusamus eaque. Sapiente ea officia corporis iure, aperiam rerum possimus molestiae voluptates adipisci, alias deleniti similique.
        </p>
        <form onSubmit={onSubmitHandler} style={{fontSize:'12px'}} className='col-12 col-sm-6 d-flex align-items-center mx-auto my-4 border button '>
            <input className=' w-100 border-0 sm:flex-1  py-3 px-3 m-0' type="email" placeholder='Enter your email' required/>
            <button type='submit' className='border-2 border-dark bg-black text-white small py-3 px-3'>SUBSCRIBE</button>
        </form>
    </div>
    </div>

  )
}

export default NewsletterBox

