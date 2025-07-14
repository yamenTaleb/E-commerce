import React from 'react'

const Title = ({text1,text2}) => {
  return (
    <div className='d-inline-flex gap-2 align-items-center mb-2'>
        <p className='text-secondary'>{text1} <span className='text-muted fw-medium'>{text2}</span></p>
        <p className='h-1px h-sm-48px w-8 w-sm-48px bg-secondary'></p>

    </div>
  )
}

export default Title

