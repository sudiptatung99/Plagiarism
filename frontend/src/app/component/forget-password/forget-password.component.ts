import { Component } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import { ToastrService } from 'ngx-toastr';
import { UserService } from 'src/app/service/user.service';

@Component({
  selector: 'app-forget-password',
  templateUrl: './forget-password.component.html',
  styleUrls: ['./forget-password.component.css']
})
export class ForgetPasswordComponent {

  resetemailObj: any = {}

  constructor(private _route: Router,
    private _user: UserService,
    private _toastr: ToastrService,
    private _spinnerService: NgxSpinnerService,
  ) { }

  onForgetPassword(ng: NgForm) {
    this._spinnerService.show();
    this._user.onforgetPassword(this.resetemailObj).subscribe((res) => {
      if (res.success == true) {
        this._spinnerService.hide();
        localStorage.setItem('userId',res.userId);
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this._route.navigate(['otp'])
      }
    }, err => {
      if (err.status == 400) {
        this._spinnerService.hide();
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
  }

  ngOnInit() {

  }

}
