import { Component } from '@angular/core';
import { NgForm } from '@angular/forms';
import { NgxSpinnerService } from 'ngx-spinner';
import { ToastrService } from 'ngx-toastr';
import { flatMap } from 'rxjs';
import { ProfileService } from 'src/app/service/profile.service';
import { UserService } from 'src/app/service/user.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent {

  profileObj: any = {};
  passwordObj: any = {
    user_id: localStorage.getItem('userId')
  };
  fileList: File[] = [];
  loading = true;
  userObj: any = {
    user_id: localStorage.getItem('userId')
  }
  constructor(private _profile: ProfileService,
    private _toastr: ToastrService,
    private _user: UserService,
    private _spinnerService: NgxSpinnerService) { }

  getProfile() {
    this.loading = true;
    this._profile.onGetProfile(this.userObj).subscribe(res => {
      if (res.success == true) {
        this.loading = false;
        this.profileObj = res.data
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
    }

    )
  }

  imageValue(event: any) {
    this.fileList[0] = event.target.files[0];
  }

  onPassword(form: NgForm) {
    this._spinnerService.show();
    this._user.onChangePassword(this.passwordObj).subscribe((res) => {
      this._spinnerService.hide();
      if (res.success == true) {
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
      }
    }, err => {
      this._spinnerService.hide();
      if (err.error.success == false) {
        if(err.error.msg.password){
          this._toastr.error(err.error.msg.password[0], 'Error', {
            timeOut: 3000,
            positionClass: 'toast-top-right',
            progressBar: true,
            progressAnimation: 'increasing'
          });
        }else{
          this._toastr.error(err.error.msg, 'Error', {
            timeOut: 3000,
            positionClass: 'toast-top-right',
            progressBar: true,
            progressAnimation: 'increasing'
          });
        }
       
      }
    })

  }


  onProfile(value: any) {
    this._profile.onGetProfileUpdate(this.profileObj).subscribe(res => {
      if (res.success == true) {
        this._toastr.success(res.msg, 'Success', {
          timeOut: 3000,
          positionClass: 'toast-top-right',
          progressBar: true,
          progressAnimation: 'increasing'
        });
        this.ngOnInit();
      }
    }, (err) => {
      this._toastr.error(err.error.msg, 'Error', {
        timeOut: 3000,
        positionClass: 'toast-top-right',
        progressBar: true,
        progressAnimation: 'increasing'
      });
    }

    )

  }

  ngOnInit(): void {
    this.getProfile();
  }

}
