import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  // variable - default false
  show: boolean = false;

  constructor() {}

  ngOnInit(): void {}

  // click event function toggle
  password() {
    this.show = !this.show;
  }
}
