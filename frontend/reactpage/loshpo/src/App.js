import Header from './components/Header'
import Landingpage from './components/Landingpage'
import Fileexplorer from './components/Fileexplorer';

function App() {

  return (
    <div className=''>

      
      {/* <Landingpage/> */}
      <Fileexplorer/>
      
    </div>
  );
}
Header.defaultProps = {
  title: 'Task tracker',
}
export default App;
