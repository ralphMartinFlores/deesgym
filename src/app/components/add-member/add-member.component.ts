import { Component, OnInit } from '@angular/core';
import Swal from 'sweetalert2';
import { DataService } from 'src/app/services/data.service';
import { MatDialog } from '@angular/material/dialog';
import { formatDate as ngFormatDate } from "@angular/common";
import { LOCALE_ID } from "@angular/core";

@Component({
  selector: 'app-add-member',
  templateUrl: './add-member.component.html',
  styleUrls: ['./add-member.component.scss'],
})
export class AddMemberComponent implements OnInit {

  private localID: string;

  ngOnInit() {
  }
  constructor(private ds: DataService, private dialog: MatDialog) { }


  sendMessage(): void {
    this.ds.sendUpdate('Message from Sender Component to Receiver Component!');
  }

  onSubmit(e: any) {
    let memdate = new Date()
    let expdate = new Date()
    expdate.setMonth(expdate.getMonth()+1);
    let f = e.target.elements
    let load = {
      member_fname: f.fname.value,
      member_mname: f.mname.value,
      member_lname: f.lname.value,
      member_mobilenum: f.mobile.value,
      member_email: f.email.value,
      member_houseno: f.houseno.value,
      member_street: f.street.value,
      member_barangay: f.barangay.value,
      member_city: f.city.value,
      member_membershipdate: memdate.toISOString().slice(0,10),
      member_membershipexp: expdate.toISOString().slice(0,10)
    }

    Swal.fire({
      title: 'All good?',
      text: 'You are about to add a new member, do you wish to proceed?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#004643',
      cancelButtonColor: '#e16162',
      confirmButtonText: 'Yes, complete membership.',
    }).then((result) => {
      if (result.isConfirmed) {
        this.ds._httpRequest('members/add', load, 2).subscribe((data:any)=>{
          if(data.code == 200) {
            this.sendMessage();
            Swal.fire({
              title: 'Success',
              text: 'This member has been added.',
              icon: 'success',
              confirmButtonColor: '#004643',
            });
            this.dialog.closeAll();
          }
        });
      }
    });
  }

}
