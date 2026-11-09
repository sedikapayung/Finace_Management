
import { BrowserRouter, Routes } from "react-router";
import './App.css'
import AppRoutes from './routes/appRoutes'

function App() {

  return (
    <BrowserRouter>
      <AppRoutes />
    </BrowserRouter>
  )
}

export default App
