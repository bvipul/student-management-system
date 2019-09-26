import BackendLayout from '../Layout/BackendLayout';
import Dashboard from '../components/Dashboard';
import UserList from '../components/Student/List';
import UserCreate from '../components/Student/Create';
import UserEdit from '../components/Student/Edit';

import CourseList from '../components/Course/List';
import CourseCreate from '../components/Course/Create';
import CourseEdit from '../components/Course/Edit';

import SemesterList from '../components/Semester/List';
import SemesterCreate from '../components/Semester/Create';
import SemesterEdit from '../components/Semester/Edit';

import SubjectList from '../components/Subject/List';
import SubjectCreate from '../components/Subject/Create';
import SubjectEdit from '../components/Subject/Edit';

import MarksList from '../components/Marks/List';
import MarksCreate from '../components/Marks/Create';
import MarksEdit from '../components/Marks/Edit';

import MyReport from '../components/MyReport/MyReport';
import Profile from '../components/Profile/Profile';

const routes = [
  { path: '/admin', exact: true, name: 'Home', component: BackendLayout },
  { path: '/admin/dashboard', name: 'Dashboard', component: Dashboard },
  { path: '/student/dashboard', name: 'Student Dashboard', component: Dashboard },
  
  // Student Management
  { path: '/admin/student', exact: true, name: 'Student Management', component: UserList },
  { path: '/admin/student/create', name: 'Create Student', component: UserCreate },
  { path: '/admin/student/:id/edit', name: 'Edit Student', component: UserEdit },

  // Course Management
  { path: '/admin/course', exact: true, name: 'Course Management', component: CourseList },
  { path: '/admin/course/create', name: 'Create Course', component: CourseCreate },
  { path: '/admin/course/:id/edit', name: 'Edit Course', component: CourseEdit },

  // Semester Management
  { path: '/admin/semester', exact: true, name: 'Semester Management', component: SemesterList },
  { path: '/admin/semester/create', name: 'Create Semester', component: SemesterCreate },
  { path: '/admin/semester/:id/edit', name: 'Edit Semester', component: SemesterEdit },

  // Subject Management
  { path: '/admin/subject', exact: true, name: 'Subject Management', component: SubjectList },
  { path: '/admin/subject/create', name: 'Create Subject', component: SubjectCreate },
  { path: '/admin/subject/:id/edit', name: 'Edit Subject', component: SubjectEdit },

  // Marks Management
  { path: '/admin/marks', exact: true, name: 'Marks Management', component: MarksList },
  { path: '/admin/marks/create', name: 'Add Marks', component: MarksCreate },
  { path: '/admin/marks/:id/edit', name: 'Edit Marks', component: MarksEdit },

  { path: '/student/my-report', name: 'My Report', component: MyReport },
  { path: '/student/profile', name: 'My Profile', component: Profile }
];

export default routes;
