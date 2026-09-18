# 🩺 Agenda de Citas para Consultorio Médico

> Sistema integral para la gestión de citas médicas, disponibilidad de especialistas, pagos en línea, historial clínico y analítica de demanda para consultorios médicos.

[![Estado](https://img.shields.io/badge/estado-en%20desarrollo-yellow)]()
[![Versión](https://img.shields.io/badge/versión-1.0.0-blue)]()
[![Licencia](https://img.shields.io/badge/licencia-MIT-green)]()

---

## 📋 Tabla de Contenidos

- [Descripción](#-descripción)
- [Características](#-características)
- [Historias de Usuario](#-historias-de-usuario)
- [Arquitectura](#-arquitectura)
- [Stack Tecnológico](#-stack-tecnológico)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Modelo de Datos](#-modelo-de-datos)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Uso](#-uso)
- [API Endpoints](#-api-endpoints)
- [Testing](#-testing)
- [Despliegue](#-despliegue)
- [Roadmap](#-roadmap)
- [Contribución](#-contribución)
- [Licencia](#-licencia)

---

## 📖 Descripción

**Agenda de Citas para Consultorio Médico** es una plataforma web que permite a los pacientes buscar disponibilidad de especialistas, agendar citas médicas, pagar la consulta (o un adelanto) y acceder a su historial clínico. Los administradores gestionan médicos, especialidades y horarios de atención, mientras que el dashboard y los reportes ofrecen visibilidad sobre las citas del día, la tasa de ausentismo, los ingresos por especialidad y las tendencias de demanda.

Este proyecto implementa **Arquitectura Onion** con separación estricta de capas, permitiendo que la lógica de negocio sea independiente de frameworks, bases de datos y servicios externos.

---

## ✨ Características

### 👤 Para Pacientes
- 🔍 Búsqueda de disponibilidad por especialidad, médico y fecha en tiempo real
- 📅 Agendamiento de citas con bloqueo automático de horarios ocupados
- 💳 Pago de consulta completo o como adelanto (Stripe, PayPal, transferencia)
- 🔄 Reprogramación y cancelación de citas con política de cancelación
- 📜 Historial de citas, recetas descargables en PDF y panel de usuario
- 🔔 Recordatorios automáticos por email/SMS/WhatsApp

### 🩺 Para Administradores
- 👨‍⚕️ CRUD completo de médicos, especialidades y horarios de atención
- 📆 Gestión de agenda por médico con validación de solapamientos
- 🚫 Bloqueo de días festivos, vacaciones y excepciones de horario
- 📊 Dashboard con citas del día, KPIs y tasa de ausentismo
- 📄 Reportes PDF de ingresos por especialidad y por médico
- 🔥 Analítica con heatmap de demanda, ranking de especialidades y tendencias

---

## 📚 Historias de Usuario

| ID | Rol | Historia | Criterios de Aceptación |
|----|-----|----------|-------------------------|
| **U1** | Paciente | Buscar disponibilidad de un especialista por fecha y hora | Filtros por especialidad, médico y fecha; resultados en tiempo real |
| **U2** | Paciente | Agendar una cita y pagar la consulta el día de la atención | Bloqueo de especialidad, médico, fecha y horario |
| **U3** | Paciente | Reprogramar o cancelar mi cita con anticipación | Política de cancelación; liberación de horario |
| **U4** | Paciente | Ver mi historial de citas y recetas | Panel de usuario; descarga de PDF; historial médico básico |
| **U5** | Administrador | Gestionar médicos, especialidades y horarios de atención | CRUD de médicos; configuración de horarios; bloqueo de días festivos |
| **U6** | Administrador | Gestionar la agenda de cada médico y evitar solapamientos | Validación de solapamiento; recordatorios automáticos; panel de citas |
| **U7** | Administrador | Dashboard con citas del día y tasa de ausentismo | Contador de citas; gráfico de ausentismo; exportable |
| **U8** | Administrador | Reportes PDF de ingresos por especialidad | Reporte mensual; desglose por médico; exportable |
| **U9** | Administrador | Analítica básica de especialidades con más demanda | Heatmap de demanda; ranking de especialidades; integración con analítica |

---

## 🏛️ Arquitectura

El proyecto sigue los principios de **Arquitectura Onion**, donde las dependencias apuntan siempre hacia el núcleo (Dominio).
