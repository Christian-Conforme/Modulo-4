from sqlalchemy.ext.asyncio import AsyncSession
from sqlalchemy.future import select
from fastapi import HTTPException
from app.db.models.empleado import Empleado
from app.schemas.empleado import EmpleadoCreate

async def get_empleados(db: AsyncSession):
    result = await db.execute(select(Empleado))
    return result.scalars().all()

async def get_empleado_by_id(db: AsyncSession, empleado_id: int):
    result = await db.execute(select(Empleado).where(Empleado.id_empleado == empleado_id))
    return result.scalars().first()

async def create_empleado(db: AsyncSession, empleado: EmpleadoCreate):
    result = await db.execute(select(Empleado).where(Empleado.correo == empleado.correo))
    existe = result.scalars().first()
    if existe:
        raise HTTPException(status_code=400, detail="El correo debe ser único")
    nuevo = Empleado(**empleado.model_dump())
    db.add(nuevo)
    await db.commit()
    await db.refresh(nuevo)
    return nuevo

async def update_empleado(db: AsyncSession, empleado_id: int, data: EmpleadoCreate):
    empleado = await get_empleado_by_id(db, empleado_id)
    if not empleado:
        raise HTTPException(status_code=404, detail="Empleado no encontrado")
    # Validar correo único si cambia
    if empleado.correo != data.correo: # type: ignore
        result = await db.execute(select(Empleado).where(Empleado.correo == data.correo))
        existe = result.scalars().first()
        if existe:
            raise HTTPException(status_code=400, detail="El correo debe ser único")
    empleado.nombre = data.nombre  # type: ignore
    empleado.cargo = data.cargo    # type: ignore
    empleado.correo = data.correo  # type: ignore
    empleado.telefono = data.telefono  # type: ignore
    await db.commit()
    await db.refresh(empleado)
    return empleado

async def delete_empleado(db: AsyncSession, empleado_id: int):
    empleado = await get_empleado_by_id(db, empleado_id)
    if not empleado:
        raise HTTPException(status_code=404, detail="Empleado no encontrado")
    await db.delete(empleado)
    await db.commit()
    return empleado