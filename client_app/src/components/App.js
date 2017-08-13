import React, {PropTypes} from 'react';
import Header from './common/Header';
import LeftBar from './common/Leftbar';

class App extends React.Component {
    render() {
        return(
            <div className="wrapper">
                <Header/>
                <LeftBar/>
                <div className="content-page">
                    <div className="content">
                        <div className="container">
                            <div className="row">
                                <div className="col-sm-12">
                                    <div className="panel panel-default">
                                        <div className="panel-body">
                                            {this.props.children}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

App.propTypes = {
    children: PropTypes.object.isRequired
};

export default App;
