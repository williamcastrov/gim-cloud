import React, { useEffect, useState } from "react";
import * as XLSX from "xlsx";
import { Modal, Button, TextField, Typography } from "@material-ui/core";
import { makeStyles } from "@material-ui/core/styles";
import 'bootstrap/dist/css/bootstrap.min.css';
import swal from 'sweetalert';
import Moment from 'moment';
import Loading from "../../../components/Loading";

// Componentes de Conexion con el Backend
import activosServices from "../../../services/Activos/Activos";

const useStyles = makeStyles((theme) => ({
  modal: {
    position: 'absolute',
    width: 1000,
    backgroundColor: theme.palette.background.paper,
    border: '2px solid #000',
    boxShadow: theme.shadows[5],
    padding: theme.spacing(2, 4, 3),
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)'
  },
  root: {
    '& > *': {
      margin: theme.spacing(1),
    },
  },
  iconos: {
    cursor: 'pointer'
  },
  inputMaterial: {
    width: '100%'
  },
  formControl: {
    margin: theme.spacing(0),
    minWidth: 290,
    maxWidth: 290,
  },
  formControl2: {
    margin: theme.spacing(0),
    minWidth: 600,
    maxWidth: 600,
  },
  extendedIcon: {
    marginRight: theme.spacing(1),
    margin: 0,
    top: 'auto',
    left: 20,
    bottom: 20,
    right: 'auto',
    position: 'fixed',
  },
  typography: {
    fontSize: 16,
    color: "#ff3d00"
  },
  button: {
    margin: theme.spacing(1),
  },
}));

function Activos() {
  const [progress, setProgress] = React.useState(0);
  const styles = useStyles();
  const [activosImportar, setActivosImportar] = useState([]);
  const [ok, setOk] = useState(true);
  const [loading, setLoading] = useState(false);

  const readExcel = (file) => {

    const promise = new Promise((resolve, reject) => {
      const fileReader = new FileReader();
      fileReader.readAsArrayBuffer(file);

      fileReader.onload = (e) => {
        const bufferArray = e.target.result;

        const wb = XLSX.read(bufferArray, { type: "buffer" });

        const wsname = wb.SheetNames[0];

        const ws = wb.Sheets[wsname];

        const data = XLSX.utils.sheet_to_json(ws);

        resolve(data);
      };

      fileReader.onerror = (error) => {
        reject(error);
      };
    });

    promise.then((d) => {
      setActivosImportar(d);
    });
  };

  const subirActivos = () => {
    var longitud = activosImportar.length;
    console.log("LONGITUD : ", longitud);

    setLoading(true);

    activosImportar && activosImportar.map((row, index) => {

      let item = {
        id_act: 0,
       /* annostranscurridos_act: row.annostranscurridos_act,
        costoadquisicion_act: row.costoadquisicion_act,
        ctadepreciacion_act: row.ctadepreciacion_act,
        cuentaactivo_act: row.cuentaactivo_act,
        depreciacionacumulada_act: row.depreciacionacumulada_act,
        depreciacionmensual_act: row.depreciacionmensual_act,
        descripcion_act: 0, //row.descripcion_act,
        diastranscurridos_act: row.diastranscurridos_act,
        factura_act: row.factura_act,
        fechaadquisicion_act: row.fechaadquisicion_act,
        fechacontable_act: row.fechacontable_act,
        fechafinalcontable_act: row.fechafinalcontable_act,
        nitproveedor_act: row.nitproveedor_act,
        nombreactivo_act: row.nombreactivo_act,
        nombreproveedor_act: row.nombreproveedor_act,
        numeroactivo_act: row.numeroactivo_act,
        placaempresa_act: row.placaempresa_act,
        valorneto_act: row.valorneto_act,
        valorresidual_act: row.valorresidual_act
        //newDet.push(item);*/
      }

      const addActivo = async () => {
        const res = await activosServices.save(item);

        if (!res.success)
          setOk(false)

      }
      addActivo();
      console.log("ACTIVOS IMPORTADAS : ", item);
    });
/*
    if (ok) {
      setLoading(false);
      swal("Subir Activos", "Archivo de Activos cargado de forma correcta!", "success", { button: "Aceptar" });
      //abrirCerrarModalCancelar();
    }
    else {
      swal("Subir Activos", "Error Subiendo Archivo de contrataciones!", "error", { button: "Aceptar" });
      //abrirCerrarModalCancelar();
    }
    */
    setLoading(false);
  }

  return (
    <div className="App">
      <div>
        <input type="file" onChange={(e) => {
          const file = e.target.files[0];
          readExcel(file);
        }} />
        <Button variant="contained" color="primary" onClick={() => subirActivos()} > Subir Archivo </Button>
        {
          loading ? <Loading /> : null
        }
      </div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">numeroactivo_act</th>
            <th scope="col">cuentaactivo_act</th>
            <th scope="col">ctadepreciacion_act</th>
            <th scope="col">nombreactivo_act</th>
            <th scope="col">descripcion_act</th>
            <th scope="col">nitproveedor_act</th>
            <th scope="col">nombreproveedor_act</th>
            <th scope="col">fechaadquisicion_act</th>
            <th scope="col">fechacontable_act</th>
            <th scope="col">fechafinalcontable_act</th>
            <th scope="col">placaempresa_act</th>
            <th scope="col">factura_act</th>
            <th scope="col">annostranscurridos_act</th>
            <th scope="col">diastranscurridos_act</th>
            <th scope="col">costoadquisicion_act</th>
            <th scope="col">valorresidual_act</th>
            <th scope="col">depreciacionacumulada_act</th>
            <th scope="col">ajustepreciacion_act</th>
            <th scope="col">valorneto_act</th>
            <th scope="col">depreciacionmensual_act</th>
          </tr>
        </thead>
        <tbody>
          {
            activosImportar.map((d) => (
              <tr key={d.id}>
                <th>{d.numeroactivo_act}</th>
                <th>{d.cuentaactivo_act}</th>
                <th>{d.ctadepreciacion_act}</th>
                <th>{d.nombreactivo_act}</th>
                <th>{d.descripcion_act}</th>
                <th>{d.nitproveedor_act}</th>
                <th>{d.nombreproveedor_act}</th>
                <th>{Moment(d.fechaadquisicion_act).format("YYYY/MM/DD")}</th>
                <th>{Moment(d.fechacontable_act).format("YYYY/MM/DD")}</th>
                <th>{Moment(d.fechafinalcontable_act).format("YYYY/MM/DD")}</th>
                <th>{d.placaempresa_act}</th>
                <th>{d.factura_act}</th>
                <th>{d.annostranscurridos_act}</th>
                <th>{d.diastranscurridos_act}</th>
                <th>{d.costoadquisicion_act}</th>
                <th>{d.valorresidual_act}</th>
                <th>{d.depreciacionacumulada_act}</th>
                <th>{d.ajustepreciacion_act}</th>
                <th>{d.valorneto_act}</th>
                <th>{d.depreciacionmensual_act}</th>
              </tr>
            ))
          }
        </tbody>
      </table>

    </div>
  );
}

export default Activos;
