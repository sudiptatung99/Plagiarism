import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
import { UserService } from 'src/app/service/user.service';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.css']
})
export class SidebarComponent {

  url = '';
  userObj: any = {
    user_id: localStorage.getItem('userId')
  };
  details: any = {};
  user_plan: any;
  isLoader=true;

  constructor(private _router: Router,
    private _userService: UserService,
    private _toastr: ToastrService) {
    this.url = _router.url;
    this.url = this.url.replace('/', '');
  }

  onLogout() {
    localStorage.clear()
    window.location.href = '/';
  }

  onGetDetails() {
    this._userService.onGetDetails(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.details = res.data;
      }
    }, (err) => {
      if (err.status == 400) {
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  onGetUserPlan() {
    this.isLoader=true;
    this._userService.onGetPlan(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.isLoader=false;
        this.user_plan = res.data[0];
      }
    }, (err) => {
      this.isLoader=false;
      if (err.status == 400) {
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  ngOnInit(): void {
    this.onGetDetails();
    this.onGetUserPlan();
  }

}
