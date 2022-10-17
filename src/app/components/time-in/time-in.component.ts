import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-time-in',
  templateUrl: './time-in.component.html',
  styleUrls: ['./time-in.component.scss']
})
export class TimeInComponent implements OnInit {

  listOfTimes: any = [];
  timeIn: any;
  
  constructor() { }

  ngOnInit(): void {
  }

  TimeIn() {
      this.timeIn = new Date();
      // this.listOfTimes.push(timeIn);
  }
}
