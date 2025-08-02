import React, { useContext, useEffect, useState } from 'react'
import { ShopContext } from '../context/ShopContext'
import Title from './Title';
import ProductItem from './ProductItem';

const LatestCollection = () => {
    const {products} = useContext(ShopContext);
    const [latestProducts,setLatestProducts] = useState([])

    useEffect(()=>{
        setLatestProducts(products.slice(0,10));
    },[])



  return (
    <div className='my-5'>
        <div className='text-center py-4 fs-3'>
            <Title text1={'LATEST'} text2={'COLLECTION'}/>
            <p style={{fontSize:'12px'}} className='w-75 m-auto fs-sm-6 fs-md-5 text-secondary'>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nihil recusandae dicta sequi tempora asperiores? Ab, dolores. Repudiandae officiis fuga deserunt non animi quos autem quasi voluptates quam. Voluptas, molestiae blanditiis!
            </p>
        </div>
        {/* Rendering Products */}
        <div className='row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4 gy-5 mt-1'>
            {
                latestProducts.map((item,index)=>(
                    <ProductItem key={index} id={item._id} image={item.image} name={item.name} price={item.price}/>
                ))
            }
        </div>
    </div>
  )
}

export default LatestCollection

