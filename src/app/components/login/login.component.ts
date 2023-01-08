import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CommonService } from 'src/app/services/common.service';
import { DataService } from 'src/app/services/data.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  // variable - default false
  show: boolean = false;

  constructor(
    private ds: DataService,
    private router: Router,
    private _commonsub: CommonService
  ) {}

  ngOnInit(): void {}

  // click event function toggle
  password() {
    this.show = !this.show;
  }

  onSubmit(e: any) {
    let f = e.target.elements;
    let param1 = f.param1.value;
    let param2 = f.param2.value;

    this._commonsub.commonSubscribe('login', { param1, param2 }, 2).then(
      async (dt: any) => {
        console.log(dt);

        if (dt.status.remarks === 'success') {
          Swal.fire({
            title: 'Success',
            text: 'Welcome, Admin!',
            icon: 'success',
            confirmButtonColor: '#004643',
          }).then((result) => {
            if (result.isConfirmed) {
              this.router.navigate(['members']);
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Incorrect Username or Password',
          })
        }
      },
      (er: any) => {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Incorrect Username or Password',
        })
      }
    );
  }
}
