
import { Component } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import { ToastrService } from 'ngx-toastr';
import { UserService } from 'src/app/service/user.service';

@Component({
  selector: 'app-otp',
  templateUrl: './otp.component.html',
  styleUrls: ['./otp.component.css']
})
export class OtpComponent {

  otpObj: any = {
    user_id: localStorage.getItem('userId')
  };

  constructor(private _route: Router,
    private _user: UserService,
    private _toastr: ToastrService,
    private _spinnerService: NgxSpinnerService) {
  }


  onGetOtp(ng: NgForm) {
    this._spinnerService.show();
    this._user.onGetOtp(this.otpObj).subscribe((res) => {
      if (res.success == true) {
        this._spinnerService.hide();
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this._route.navigate(['reset-password'])
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

  resendOtp() {
    this._spinnerService.show();
    this._user.onResendOtp({ user_id: localStorage.getItem('userId') }).subscribe((res) => {
      if (res.success == true) {
        this._spinnerService.hide();
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
}
