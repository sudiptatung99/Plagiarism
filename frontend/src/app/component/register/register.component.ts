import { Component } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import { ToastrService } from 'ngx-toastr';
import { UserService } from 'src/app/service/user.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent {

  registerObj: any = {}
  otpActive = false;

  constructor(private _userService: UserService,
    private _router: Router,
    private _spinnerService: NgxSpinnerService,
    private _toastr: ToastrService) { }

  onRegister(form: NgForm) {
    this._spinnerService.show();
    this._userService.onRegister(this.registerObj).subscribe(res => {
      if (res.success == true) {
        this._spinnerService.hide();
        this.otpActive = true;
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    }, (err) => {
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

  otpVerify(form: NgForm) {
    this._spinnerService.show();
    this._userService.onRegisterOtp(this.registerObj).subscribe(res => {
      if (res.success == true) {
        this._spinnerService.hide();
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this._router.navigate(['login']); 
      }
    },err=>{
      this._spinnerService.hide();
      if (err.status == 400) {
        this._toastr.error(err.error.msg, 'Error', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
      
    });
    
  }

}
