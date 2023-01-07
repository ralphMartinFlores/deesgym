import { Component, OnInit } from '@angular/core';
import Swal from 'sweetalert2';
import { DataService } from 'src/app/services/data.service';
import { MatDialog } from '@angular/material/dialog';

@Component({
  selector: 'app-edit-member',
  templateUrl: './edit-member.component.html',
  styleUrls: ['./edit-member.component.scss'],
})
export class EditMemberComponent implements OnInit {

  member: any;

  constructor(private ds: DataService, private dialog: MatDialog) { }

  ngOnInit(): void {
    this.member = this.ds.SharedData
  }

  updateMemberAlert() {
  }

  sendMessage(): void {
    this.ds.sendUpdate('Message from Sender Component to Receiver Component!');
  }

  onSubmit(e: any) {
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
    }

    Swal.fire({
      title: 'All good?',
      text: 'Please make sure that all changes are final.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#004643',
      cancelButtonColor: '#e16162',
      confirmButtonText: 'Yes, save my changes.',
    }).then((result) => {
      if (result.isConfirmed) {
        this.ds._httpRequest('members/update/' + f.id.value, load, 2).subscribe((data:any)=>{
          if(data.code == 200) {
            this.sendMessage();
            Swal.fire({
              title: 'Success',
              text: 'Changes have been saved.',
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
