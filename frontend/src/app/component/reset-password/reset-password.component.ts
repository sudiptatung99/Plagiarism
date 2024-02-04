import { Component } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import { ToastrService } from 'ngx-toastr';
import { UserService } from 'src/app/service/user.service';

@Component({
  selector: 'app-reset-password',
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.css']
})
export class ResetPasswordComponent {

  resetObj: any = {
    user_id: localStorage.getItem('userId')
  }

  constructor(private _route: Router,
    private _user: UserService,
    private _toastr: ToastrService,
    private _spinnerService: NgxSpinnerService) { }

  onResetPassword(ng:NgForm) {
    this._spinnerService.show();
    this._user.onResetPassword(this.resetObj).subscribe((res)=>{
      if (res.success == true) {
        this._spinnerService.hide();
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this._route.navigate(['login'])
      }
    },err=>{
      if (err.status == 400) {
        this._spinnerService.hide();
        this._toastr.error(err.error.msg.password[0], 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    })
    
  }
}
