import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CommonService } from 'src/app/services/common.service';
import { DataService } from 'src/app/services/data.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  // variable - default false
  show: boolean = false;

  constructor(private ds: DataService, private router: Router, private _commonsub: CommonService) { }

  ngOnInit(): void {}

  // click event function toggle
  password() {
    this.show = !this.show;
  }
  
  onSubmit(e: any) {
    let f = e.target.elements;
    let param1 = f.param1.value;
    let param2 = f.param2.value;

    this._commonsub.commonSubscribe('login',{param1,param2},2).then(async (dt: any) => {
      console.log(dt);
      
      if (dt.status.remarks === 'success') {
        // this.user.setLoading(false);
        // this._snackbar.open("Welcome, "+data.payload.fullname +"!", "", {duration:1500});        
        // this.user.setUserData(data.payload);    
        // this.user.setProfilePicture(data.payload.img);    
        // this.user.setLoginState();

        // if (data.payload.reset == 0) {
        //   this.changePassword();
        // } else {
        this.router.navigate(['members']);
        // }
  
      } else {
        // this.errMsg = data.status.message;
      }
    }, (er: any) => {
      // let data = this.user._decrypt(er.error.a);
      // this.user.setLoading(false);
      // this.errMsg = data.status.message;
    });
  }
}
