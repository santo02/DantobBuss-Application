<template>
  <div>
    <h3 pa-3 ma-3>E-ticket</h3>
    <v-card width="500px" class="mx-auto p-3" ref="card">
      <div class="container m-3">
        <div class="text-center">
          <v-avatar size="40" class="mt-2 ml-2">
            <img
              :src="require('@/assets/images/logos/logo-KBT.png').default"
              max-height="50px"
              max-width="100px"
              alt="avatar"
            />
          </v-avatar>
          <h5>KBT</h5>
          <h5>E-Ticket</h5>
          <h6>{{ this.ticket.nomor_pintu }}</h6>
          <h6>{{ this.ticket.tanggal }}</h6>
        </div>
        <v-simple-table class="p-3">
          <template>
            <thead>
              <tr>
                <th colspan="2" class="text-left">
                  <h2>Rincian Bus</h2>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Tipe</td>
                <td>: {{ this.ticket.type }}</td>
              </tr>
              <tr>
                <td>Asal</td>
                <td>: {{ this.ticket.derpature }}</td>
              </tr>
              <tr>
                <td>Tujuan</td>
                <td>: {{ this.ticket.arrival }}</td>
              </tr>
              <tr>
                <th colspan="2">
                  <h2>Rincian Penumpang</h2>
                </th>
              </tr>
              <tr>
                <td>Nama</td>
                <td>: {{ this.ticket.name }}</td>
              </tr>
              <tr>
                <td>Umur</td>
                <td>: {{ this.ticket.age }}</td>
              </tr>
              <tr>
                <td>Bangku</td>
                <td>: {{ this.ticket.num_seats }}</td>
              </tr>
              <tr class="p-3">
                <td>Tarif</td>
                <td class="text-right">
                  <b> Rp.{{ this.ticket.harga }}</b>
                </td>
              </tr>
              <tr class="mt-3">
                <td>
                  <h3>Status Pembayaran</h3>
                </td>
                <td class="text-right">
                  <h3 class="text--primary">{{ this.ticket.status }}</h3>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </div>
    </v-card>
    <div class="mx-auto text-center mt-4" width="500px">
      <v-btn color="primary" width="500px" height="40px" @click="downloadCard"
        >Download</v-btn
      >
    </div>
  </div>
</template>

<script>
import jsPDF from "jspdf";
import "jspdf-autotable";
import axios from "axios";
import "moment/locale/id";
export default {
  setup() {
    return {};
  },
  computed: {},
  data() {
    return {
      ticket: "",
    };
  },

  mounted() {
    this.getTIckets();
  },

  methods: {
    getTIckets() {
      const access_token = localStorage.getItem("access_token");

      axios
        .get(`/api/pesanan/ticket/${this.$route.params.id}`, {
          headers: {
            Authorization: `Bearer ${access_token}`,
          },
        })
        .then((response) => {
          this.ticket = response.data.data[0];
          console.log(this.ticket);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    downloadCard() {
      // Create a new jsPDF instance
      const doc = new jsPDF();
      // Set the document properties
      doc.setProperties({
        title: "E-ticket Koperasi Bintang Tapanuli (KBT)",
        author: "Your Name",
        subject: "E-ticket Koperasi Bintang Tapanuli (KBT)",
        keywords: "E-ticket Koperasi Bintang Tapanuli (KBT), bus, passenger",
        creator: "Your Name",
      });

      const logoImg = new Image();
      logoImg.src = require("@/assets/images/logos/logo-KBT.png").default;
      doc.addImage(logoImg, "PNG", 15, 10, 15, 15);

      // Define the column widths for the table
      const columnWidths = [50, 50, 50, 50];

      // Add the header for the table
      doc.setFontSize(18);
      doc.setFont("helvetica", "bold");
      doc.text(
        "E-ticket Koperasi Bintang Tapanuli (KBT)",
        doc.internal.pageSize.getWidth() / 2,
        20,
        { align: "center" }
      );

      // Define the data for the table
      const tableData = [
        ["BUS : ", this.ticket.nomor_pintu, ""],
        ["Tanggal : ", this.ticket.tanggal, ""],
        ["", "", "", ""],
        ["Nama: ", this.ticket.name, "Tipe :", this.ticket.type],
        ["Umur: ", this.ticket.age, "Asal : ", this.ticket.derpature],
        ["Nomor Bangku :", this.ticket.num_seats, "Tujuan: ", this.ticket.arrival],
        ["", "", "Tarif", "Rp." + this.ticket.harga],
        ["", "", "Status Pembayaran", this.ticket.status],
      ];

      // Add the table to the PDF document
      doc.autoTable({
        startY: 30,
        head: [["", "", "", ""]],
        body: tableData,
        columnStyles: {
          0: { cellWidth: columnWidths[0] },
          1: { cellWidth: columnWidths[1] },
          2: { cellWidth: columnWidths[2] },
          3: { cellWidth: columnWidths[3] },
        },
        theme: "plain",
        styles: {
          font: "courier",
          fontSize: 12,
        },
      });

      // Save the PDF document
      doc.save("e-ticket.pdf");

      // Print the PDF document
      autoPrint(doc);
    },
  },
};
</script>
