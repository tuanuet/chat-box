import React, {PropTypes} from 'react';

class App extends React.Component {
    // componentWillMount() {
    //     const script = document.createElement("script");
    //
    //     script.src = "/js/myScript.js";
    //     script.async = true;
    //
    //     document.body.appendChild(script);
    //
    //     const script1 = document.createElement("script");
    //
    //     script1.src = "/vendor/light/assets/plugins/isotope/js/isotope.pkgd.min.js";
    //     script1.async = true;
    //
    //     document.body.appendChild(script1);
    //
    //     const script2 = document.createElement("script");
    //
    //     script2.src = "/vendor/light/assets/plugins/magnific-popup/js/jquery.magnific-popup.min.js";
    //     script2.async = true;
    //
    //     document.body.appendChild(script2);
    // }

    render() {
        return(
            <div className="wrapper">
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
