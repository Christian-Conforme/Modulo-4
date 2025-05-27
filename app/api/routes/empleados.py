from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.ext.asyncio import AsyncSession
from sqlalchemy.future import select
from app.db.base import SessionLocal
from app.schemas.empleado import EmpleadoCreate, EmpleadoOut
from app.services.empleado import get_empleados, create_empleado
from app.api.routes.auth import get_current_user
from app.db.models.empleado import Empleado

router = APIRouter()

async def get_db():
    async with SessionLocal() as session:
        yield session

@router.get("/", response_model=list[EmpleadoOut])
async def listar_empleados(db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    return await get_empleados(db)

@router.get("/{empleado_id}", response_model=EmpleadoOut)
async def obtener_empleado(empleado_id: int, db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    result = await db.execute(select(Empleado).where(Empleado.id_empleado == empleado_id))
    empleado = result.scalars().first()
    if not empleado:
        raise HTTPException(status_code=404, detail="Empleado no encontrado")
    return empleado

@router.post("/", response_model=EmpleadoOut)
async def crear_empleado(data: EmpleadoCreate, db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    return await create_empleado(db, data)

@router.put("/{empleado_id}", response_model=EmpleadoOut)
async def actualizar_empleado(empleado_id: int, data: EmpleadoCreate, db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    result = await db.execute(select(Empleado).where(Empleado.id_empleado == empleado_id))
    empleado = result.scalars().first()
    if not empleado:
        raise HTTPException(status_code=404, detail="Empleado no encontrado")
    # Aquí deberías implementar la lógica real de actualización en la base de datos
    # Por ahora solo retorna el encontrado
    return empleado

@router.delete("/{empleado_id}", response_model=EmpleadoOut)
async def eliminar_empleado(empleado_id: int, db: AsyncSession = Depends(get_db), user=Depends(get_current_user)):
    result = await db.execute(select(Empleado).where(Empleado.id_empleado == empleado_id))
    empleado = result.scalars().first()
    if not empleado:
        raise HTTPException(status_code=404, detail="Empleado no encontrado")
    # Aquí deberías implementar la lógica real de eliminación en la base de datos
    # Por ahora solo retorna el encontrado
    return empleado