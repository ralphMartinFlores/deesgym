import { Component, OnInit } from '@angular/core';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-edit-member',
  templateUrl: './edit-member.component.html',
  styleUrls: ['./edit-member.component.scss'],
})
export class EditMemberComponent implements OnInit {
  constructor() {}

  ngOnInit(): void {}

  updateMemberAlert() {
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
        Swal.fire({
          title: 'Success',
          text: 'Changes have been saved.',
          icon: 'success',
          confirmButtonColor: '#004643',
        });
      }
    });
  }
}
