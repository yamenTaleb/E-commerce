import React, { useContext, useEffect, useState } from 'react'
import {ShopContext} from '../context/ShopContext'
import { assets } from '../assets/assets';
import Title from '../Components/Title';
import ProductItem from '../Components/ProductItem';

const Collection = () => {
    const {products , search , showSearch} = useContext(ShopContext);
    const [showFilter,setShowFilter] = useState(false);
    const [filterProducts,setFilterProducts]=useState([]);
    const [category,setCategory]=useState([]);
    const [subCategory,setSubCategory]=useState([]);
    const [sortType,setSortType]=useState('relavent');

    const toggleCategory = (e)=>{
        if (category.includes(e.target.value)) {
            setCategory(prev=>prev.filter(item=>item !== e.target.value))
        }
        else {
            setCategory(prev=>[...prev,e.target.value])
        }
    }

    const toggleSubCategory = (e)=>{
        if (subCategory.includes(e.target.value)) {
            setSubCategory(prev=>prev.filter(item=>item !== e.target.value))
        }
        else {
            setSubCategory(prev=>[...prev,e.target.value])
        }
    }

    const applyFilter = ()=>{

        let productsCopy = products.slice();
        if (showSearch && search) {
            productsCopy = productsCopy.filter(item=>item.name.toLowerCase().includes(search.toLowerCase()))
        }
        if (category.length > 0) {
            productsCopy = productsCopy.filter(item=>category.includes(item.category));
        }
        if (subCategory.length > 0) {
            productsCopy = productsCopy.filter(item=> subCategory.includes(item.subCategory))
        }

        setFilterProducts(productsCopy)
    }

    const sortProduct = ()=> {
        let fpCopy = filterProducts.slice();

        switch (sortType) {
            case 'low-high':
                setFilterProducts(fpCopy.sort((a,b)=>(a.price - b.price)));
                break;
            case 'high-low':
                setFilterProducts(fpCopy.sort((a,b)=>(b.price - a.price)));
                break;
            default:
                applyFilter();
                break;
        }
    }

    // useEffect(()=>{
    //     setFilterProducts(products)
    // },[])

    useEffect(()=>{
        applyFilter();
    },[category,subCategory,search,showSearch])

    useEffect(()=>{
        sortProduct();
    },[sortType])

  return (
    <div className='d-flex flex-column gap-1 flex-sm-row gap-sm-4 pt-4 border-top'>
        {/* filter options */}
        <div style={{minWidth:"240px"}}>
            <p onClick={()=>setShowFilter(!showFilter)} className='fs-4 my-2 d-flex align-items-center pointer gap-2'>FILTERS
                <img style={{height:"12px"}} className={`d-sm-none ${showFilter?'rotate-90':''}`} src={assets.dropdown_icon} alt="" />
            </p>
            {/* category filter */}
            <div className={`border border-secondary ps-5 py-3 mt-4 ${showFilter?'':'d-none'} d-sm-block`}>
                <p className='mb-3 fs-6 fw-medium'>GATEGORIES</p>
                <div className='d-flex flex-column gap-2 fs-6 font-light text-secondary'>
                    <p className='d-flex gap-2'>
                        <input className='w-3' type="checkbox" value={'Men'} onChange={toggleCategory}/>Men
                    </p>
                    <p className='d-flex gap-2'>
                        <input className='w-3' type="checkbox" value={'Women'} onChange={toggleCategory}/>Women
                    </p>
                    <p className='d-flex gap-2'>
                        <input className='w-3' type="checkbox" value={'Kids'} onChange={toggleCategory}/>Kids
                    </p>
                </div>
            </div>
            {/* subCategory filter */}
            <div className={`border border-secondary ps-5 py-3 my-3 ${showFilter?'':'d-none'} d-sm-block`}>
                <p className='mb-3 fs-6 fw-medium'>TYPE</p>
                <div className='d-flex flex-column gap-2 fs-6 font-light text-secondary'>
                    <p className='d-flex gap-2'>
                        <input className='w-3' type="checkbox" value={'Topwear'} onChange={toggleSubCategory}/>Topwear
                    </p>
                    <p className='d-flex gap-2'>
                        <input className='w-3' type="checkbox" value={'Bottomwear'} onChange={toggleSubCategory}/>Bottomwear
                    </p>
                    <p className='d-flex gap-2'>
                        <input className='w-3' type="checkbox" value={'Winterwear'} onChange={toggleSubCategory}/>Winterwear
                    </p>
                </div>
            </div>
        </div>

        {/* right side */}
        <div className='flex-grow-1'>
            <div className='d-flex justify-content-between text-base sm-text-2xl mb-4'>
                <Title text1={'ALL'} text2={'COLLECTIONS'}/>
                {/* product sort*/}
                <select onChange={(e)=>setSortType(e.target.value)} className='border border-2 border-gray-300 bg-white fs-6 px-2'>
                    <option value="relavent">Sort by: Relavent</option>
                    <option value="low-high">Sort by: Low to High</option>
                    <option value="high-low">Sort by: High to low</option>
                </select>
            </div>

            {/* map products */}
            <div className='d-grid gap-4 custom-grid'>
                {
                    filterProducts.map((item,index)=>(
                        <ProductItem key={index} name={item.name} id={item._id} price={item.price} image={item.image}/>
                    ))


                }
            </div>
        </div>
    </div>
  )
}

export default Collection

