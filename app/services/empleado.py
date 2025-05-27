from sqlalchemy.ext.asyncio import AsyncSession
from sqlalchemy.future import select
from fastapi import HTTPException
from app.db.models.empleado import Empleado
from app.schemas.empleado import EmpleadoCreate

async def get_empleados(db: AsyncSession):
    result = await db.execute(select(Empleado))
    return result.scalars().all()

async def create_empleado(db: AsyncSession, empleado: EmpleadoCreate):
    # Verifica si el correo ya existe
    result = await db.execute(select(Empleado).where(Empleado.correo == empleado.correo))
    if result.scalars().first():
        raise HTTPException(status_code=400, detail="El correo debe ser único")
    nuevo = Empleado(**empleado.dict())
    db.add(nuevo)
    await db.commit()
    await db.refresh(nuevo)
    return nuevo