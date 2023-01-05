import {
  AfterViewInit,
  Component,
  HostListener,
  ViewChild,
} from '@angular/core';
import { MatPaginator } from '@angular/material/paginator';
import { MatTableDataSource } from '@angular/material/table';
import { MatSidenav } from '@angular/material/sidenav';
import { MatDialog } from '@angular/material/dialog';
import { AddTransactionComponent } from '../add-transaction/add-transaction.component';

@Component({
  selector: 'app-transactions-table',
  templateUrl: './transactions-table.component.html',
  styleUrls: ['./transactions-table.component.scss'],
})
export class TransactionsTableComponent implements AfterViewInit {
  displayedColumns: string[] = ['name', 'timein', 'timeout', 'action'];
  dataSource = new MatTableDataSource<PeriodicElement>(ELEMENT_DATA);

  opened = true;
  @ViewChild('sidenav', { static: true }) sidenav: MatSidenav;

  @ViewChild(MatPaginator) paginator: MatPaginator;

  constructor(public dialog: MatDialog) {}

  openAddTransactionDialog() {
    let dialogRef = this.dialog.open(AddTransactionComponent, {
      width: '400px',
      height: '90vh',
    });
    dialogRef.afterClosed().subscribe((result) => {
      console.log('Add transaction modal closed.');
    });
  }

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;

    console.log(window.innerWidth);
    if (window.innerWidth < 768) {
      this.opened = false;
    } else {
      this.opened = true;
    }
  }

  @HostListener('window:resize', ['$event'])
  onResize(event: { target: { innerWidth: number } }) {
    if (event.target.innerWidth < 768) {
      this.opened = false;
    } else {
      this.opened = true;
    }
  }
  isBiggerScreen() {
    const width =
      window.innerWidth ||
      document.documentElement.clientWidth ||
      document.body.clientWidth;
    if (width < 768) {
      return true;
    } else {
      return false;
    }
  }
}

export interface PeriodicElement {
  name: string;
  position: number;
  timein: string;
  timeout: string;
}

const ELEMENT_DATA: PeriodicElement[] = [
  {
    position: 1,
    name: 'Jerome Socorro Labuguen Marquez',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 2,
    name: 'Christian Leroy Jenkins Dantes',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 3,
    name: 'Leonardo Eneas Serad Magtibay',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 4,
    name: 'Alarico Mitchell Tupas Benítez',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 5,
    name: 'Juan Dela Cruz',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 6,
    name: 'Jerome Socorro Labuguen Marquez',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 7,
    name: 'Christian Leroy Jenkins Dantes',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 8,
    name: 'Leonardo Eneas Serad Magtibay',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 9,
    name: 'Alarico Mitchell Tupas Benítez',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 10,
    name: 'Juan Dela Cruz',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 11,
    name: 'Jerome Socorro Labuguen Marquez',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 12,
    name: 'Christian Leroy Jenkins Dantes',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 13,
    name: 'Leonardo Eneas Serad Magtibay',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 14,
    name: 'Alarico Mitchell Tupas Benítez',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 15,
    name: 'Juan Dela Cruz',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 16,
    name: 'Jerome Socorro Labuguen Marquez',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 17,
    name: 'Christian Leroy Jenkins Dantes',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 18,
    name: 'Leonardo Eneas Serad Magtibay',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 19,
    name: 'Alarico Mitchell Tupas Benítez',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
  {
    position: 20,
    name: 'Juan Dela Cruz',
    timein: 'January 1, 2023 12:30pm',
    timeout: 'January 1, 2023 2:30pm',
  },
];
