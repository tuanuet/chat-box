import React, {PropTypes} from 'react';
import{connect} from 'react-redux';
import * as courseActions from '../../actions/courseAction';
import {bindActionCreators} from 'redux';
import CourseForm from './CourseForm';
import toastr from 'toastr';

/**
 * class quan ly cac form create, edit and delete course
 */
class ManageCoursePage extends React.Component {
  constructor(props, context) {
    super(props, context);

    this.state = {
      course: Object.assign({}, this.props.course),
      errors: {},
      saving: false
    };

    this.updateCourseState = this.updateCourseState.bind(this);
    this.saveCourse = this.saveCourse.bind(this);
  }

  /**
   * ham nay se cap nhat state khi co prop moi them vao
   * @param nextProps
   */
  componentWillReceiveProps(nextProps) {
    if(this.state.course.id != nextProps.course.id) {
      this.setState({
        course: Object.assign({}, nextProps.course)
      });
    }
  }

  /**ham thay doi gia tri cua cac truong trong form*/
  updateCourseState(event) {

    const field = event.target.name;
    let course = Object.assign({}, this.state.course);
    course[field] = event.target.value;
    console.log('on change on field: '+ field + " ,value: " + course[field]);
    this.setState({
        course: course
    });
    this.saveCourse = this.saveCourse.bind(this);
  }

  /**
   * ham save course
   * @param event
   */
  saveCourse(event) {
    console.log("save course...");
    this.setState({saving: true})
    event.preventDefault();
    console.log(this.state.course);
    this.props.actions.saveCourse(this.state.course)
      .then(() => this.redirect())
      .catch(error => {
        toastr.error(error);
        this.setState({saving: false});
      });
  }

  redirect() {
    this.setState({saving: false});
    toastr.success('Course Saved');
    this.context.router.push('/courses');
  }

  render() {
    return(
      <div>
        <CourseForm
          onChange={this.updateCourseState}
          course={this.state.course}
          errors={this.state.errors}
          allAuthors={this.props.authors}
          onSave={this.saveCourse}
          saving={this.state.saving}/>
      </div>
    );
  }

}

ManageCoursePage.propTypes = {
  course: PropTypes.object.isRequired,
  authors: PropTypes.array.isRequired,
  actions: PropTypes.object.isRequired
};

/**context route// tam hieu no la de redirect ve list courses */
ManageCoursePage.contextTypes = {
  router: PropTypes.object
};

/**
 *
 * @param courses
 * @param courseId
 */
function getCourseById(courses, courseId) {
  const course = courses.filter(course => course.id == courseId);
  if(course.length) return course[0];
  return null;
}

/**
 * ham liet ke cac state co cua component
 * @param state
 * @param ownProps
 * @returns {{courses: *}}
 */
function mapStateToProps(state, ownProps) {

  const courseId = ownProps.params.id; //from the path `/course/:id`


  let course = {
    id: '',
    watchHref: '',
    title: '',
    authorId: '',
    length: '',
    category: ''
  };
  /**
   * validate xem co course hay chua boi vi khi onload thi ajax call chua ve
   */
  if(courseId && state.courses.length > 0) {
    course = getCourseById(state.courses, courseId);
  }

  /** ham nay de format author cho giong chuan cua select input*/
  const authorFormattedForDropdown = state.authors.map(author => {
    return {
      value: author.id,
      text: author.firstName + ' ' + author.lastName
    };
  });

  return {
    course: course,
    authors: authorFormattedForDropdown
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

export default connect(mapStateToProps, mapDispatchToProps)(ManageCoursePage);

