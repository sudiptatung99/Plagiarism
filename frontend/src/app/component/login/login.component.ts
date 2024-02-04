import { Component } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import { ToastrService } from 'ngx-toastr';
import { UserService } from 'src/app/service/user.service';
declare var $: any;
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  loginObj: any = {}
  showpassword=false;
  constructor(private _userService: UserService,
              private _spinnerService: NgxSpinnerService,
              private _toastr: ToastrService) { } 

  onLogin(form: NgForm) {  
    this._spinnerService.hide(); 
    this._userService.onLogin(this.loginObj).subscribe(res => { 
      if(res.success == true) {    
        localStorage.setItem('userId', res.userId); 
        localStorage.setItem('accessToken', res.accessToken); 
        window.location.href = '/'; 
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

  hidePassword(){
    this.showpassword = true;
    $('#password').attr('type','text')
  }
  showPassword(){
    this.showpassword = false;
    $('#password').attr('type','password')
  }
 
}
