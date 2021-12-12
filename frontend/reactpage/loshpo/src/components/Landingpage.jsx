import Navbar from './Navbar'
const Landingpage = () => {
    
    // Network status - either device is connected to any router or not
    const networkStatus = 'You are not connected to network.'


    return (
        <>
            {/* Here we are creating Navbar */}
           <Navbar/>
            {/* Here we are creating main content */}
            <div className="container-fluid gradient text-center  px-0 ">
                <img className="img-fluid my-4" src="assets\Share_Monochromatic.svg" alt="Share_Monochromatic" />
                <div className="d-grid gap-2 col-6 mx-auto">

                    <button type="button" className="btn btn-outline-warning btn-lg my-2">Start sharing</button>

                </div>
                <h3 className="px-2">{networkStatus}</h3>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,32L48,53.3C96,75,192,117,288,128C384,139,480,117,576,96C672,75,768,53,864,42.7C960,32,1056,32,1152,53.3C1248,75,1344,117,1392,138.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>

            </div>
        </>
    )
}

export default Landingpage
