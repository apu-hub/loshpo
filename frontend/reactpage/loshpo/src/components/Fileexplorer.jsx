import Navbar from "./Navbar"
import  { useState } from 'react';


const Fileexplorer = () => {
    const url = 'temporary/bootstrap/assets'
    const files = [
        {
            filename: "music file",
            filetype: "nei"
        },
        {
            filename: "video file",
            filetype: "video"
        },
        {
            filename: "image file",
            filetype: "image"
        },
        {
            filename: "others file",
            filetype: "others"
        },
        {
            filename: "folder file",
            filetype: "folder"
        },
    ]
    return (
        <div>
            <Navbar />


            {/* Here we are creating file URL area */}

            <Fileurlbar url={url} />


            {/* Here we are creating the content area */}
            <div className="container">
                <div className="row g-3">
                    {
                        files.map((data, key) => {
                            return (
                                <File filename={data.filename}
                                    filetype={data.filetype}
                                    key={key}
                                />
                            )
                        })
                    }



                </div>
            </div>
        </div>
    )
}



const Fileurlbar = (props) => {
    const [alertCheck,updatealert] = useState(false)
    const goback = () => {
        
        updatealert(true)
        
    }
    return (
        <>
            <div className="input-group flex-nowrap mb-2 ">
                <span className="input-group-text btn-outline-secondary" id="addon-wrapping" onClick={goback}><img className="icon" src="assets/arrow-left-circle.svg" alt="" /></span>
                <input type="text" className="form-control" placeholder="File url" value={props.url} aria-label="Username" aria-describedby="addon-wrapping" readOnly />
            </div>

            {/* Aleart box */}
            {alertCheck ? <div className="alert alert-warning alert-dismissible fade show fixed-bottom" role="alert">
                <strong>Going back!</strong> You can see privious folder now.
                <button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close" onClick={()=> updatealert(false)}></button>
            </div> : ''}
            
        </>
    )
}

const File = (props) => {
    const [shareCheck, updateshare] = useState(false)
    const [alertCheck,updatealert] = useState(false)
    const goback = () => {
        updateshare(true)
        updatealert(true)
        
    }
    const iconLoaction = {
        music: 'assets/file-music.svg',
        video: "assets/film.svg",
        others: 'assets/file-earmark.svg',
        folder: 'assets/folder.svg',
        image: 'assets/file-earmark-image.svg',
        share:'assets/share.svg',
        sharefill: 'assets/share-fill.svg'
    }
    return (
        <>
            <div className="col-md-4 border py-2">
                <div className="row justify-content-center align-items-center">
                    {/* Filetype icon */}
                    <div className="col-2">
                        <img className="img-fluid icon"
                            src={
                                iconLoaction[props.filetype] ||  iconLoaction['others']}
                            alt="" />
                    </div>

                    {/* File name */}
                    <div className="col-7">{
                        props.filename}
                    </div>

                    {/* action Button */}
                    <div className="col-3 px-3 justify-content-end d-inline-flex">
                        <img className="img-fluid "
                            src={shareCheck ? iconLoaction['sharefill'] : iconLoaction['share']}

                            alt=""
                            onClick={goback} />
                    </div>
                </div>
            </div>
            {/* Aleart box */}
            {alertCheck ? <div className="alert alert-warning alert-dismissible fade show fixed-bottom" role="alert">
                <strong>You have shared this file!</strong> others can download it. 
                <button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close" onClick={()=> updatealert(false)}></button>
            </div> : ''}

        </>
    )
}

File.defaultProps = {
    filename: 'file name'
}

export default Fileexplorer
