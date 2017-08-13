import React, {PropTypes} from 'react';
import{connect} from 'react-redux';
import * as courseActions from '../../actions/courseAction';
import {bindActionCreators} from 'redux';
import CourseList from './CourseList';
import {browserHistory} from 'react-router'

class CoursesPage extends React.Component {

  constructor(props, context) {
    super(props, context);

    this.redirectToAddCoursePage = this.redirectToAddCoursePage.bind(this);

  }

  redirectToAddCoursePage() {
    browserHistory.push('/course');
  }

  render() {
    const {courses} = this.props;

    return(
      <div>
        <h1>Courses</h1>
        <input
          type="submit"
          value="Add course"
          className="btn btn-primary"
          onClick={this.redirectToAddCoursePage}/>
        <CourseList courses = {courses}/>
      </div>
    );
  }
}

/**
 * export voi connect de react component co the tuong tac voi redux, 2 tham bien kia la 2 ham mac dinh
 * mapStateToProps la ham cap nhat thay doi state
 * mapDispatchToProps la ham yeu cau thay doi state
 */

CoursesPage.propTypes = {
  actions: PropTypes.object.isRequired,
  courses: PropTypes.array.isRequired
};

/**
 * ham liet ke cac state co cua compoenent
 * @param state
 * @param ownProps
 * @returns {{courses: *}}
 */
function mapStateToProps(state, ownProps) {
  return {
    courses: state.courses
  };
}

/**
 * ham liet ke cac action co the co cua component
 * @param dispatch
 */
function mapDispatchToProps(dispatch) {
  return {
    actions: bindActionCreators(courseActions, dispatch)
  };
}

export default connect(mapStateToProps, mapDispatchToProps)(CoursesPage);