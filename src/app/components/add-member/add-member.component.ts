import { Component, OnInit } from '@angular/core';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-add-member',
  templateUrl: './add-member.component.html',
  styleUrls: ['./add-member.component.scss'],
})
export class AddMemberComponent implements OnInit {
  constructor() {}

  ngOnInit(): void {}

  addMemberAlert() {
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
        Swal.fire({
          title: 'Success',
          text: 'This member has been added.',
          icon: 'success',
          confirmButtonColor: '#004643',
        });
      }
    });
  }
}
